<?php

namespace App\Http\Controllers;


use App\Models\Personage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PersonageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $personages = Personage::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('personages.index')
            ->with('personages', $personages);
    }

    public function create()
    {
        return view('personages.create');
    }

    public function store(Request $request)
    {
        $rules['name'] = 'required|string|max:255';
        $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png|max:30000';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('personages/create')
                ->withErrors($validator)
                ->withInput();
        }

        $personage = new Personage();
        $personage->name = $request->get('name');

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = str_replace(' ', '', $request->name) . '_' . 'image' . '.' . $extension;
            $request->file('image')->move('uploads/personages', $image);
            $personage->image = $image;
        }

        $personage->save();

        return redirect('/personages')->with('success', 'Personages created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $personage = Personage::where('id', $id)->first();

        if ($personage == null) {
            return redirect('/personages')->with('error', 'Personage not found!');
        }

        return view('personages.edit')
            ->with('personage', $personage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $personage = Personage::find($id);

        $rules['name'] = 'required|string|max:255';
        $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png|max:30000';

        if ($personage->image == null) {
            $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        } else {
            $rules['image'] = 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('personages/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }


        $personage->name = $request->get('name');

        if ($request->hasFile('image')) {
            if (file_exists(public_path('uploads/personages/' . $personage->image . '')) && !empty($personage->image)) {
                unlink(public_path('uploads/personages/' . $personage->image . ''));
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = str_replace(' ', '-', $request->name) . '_' . 'image' . '.' . $extension;
            $request->file('image')->move('uploads/personages', $image);
            $personage->image = $image;
        }

        $personage->save();

        return redirect('/personages')->with('success', 'Personage updated successfully.');
    }

    public function deletePersonage($id)
    {
        if (Auth::user()->isAdmin()) { // only admin can delete users
            $personage = Personage::findOrFail($id);;

            if ($personage) {
                $personage->delete();
                return redirect()->route('personageIndex')
                    ->with('success', 'Personage deleted successfully');
            }
        } else {
            return redirect()->route('personageIndex')
                ->with('warning', 'You don\'t have permissions to delete personages');
        }

        return redirect()->route('personageIndex');

    }


    public function deletePersonageImageFile($id)
    {

        if (Auth::user()->isAdmin()) { // only admin can delete users
            $personage = Personage::findOrFail($id);;

            if ($personage->image) {
                if (file_exists(public_path('uploads/personages/' . $personage->image . ''))) {
                    unlink(public_path('uploads/personages/' . $personage->image . ''));
                }
                $personage->image = null;
                $personage->save();
                return redirect()->route('personageIndex')
                    ->with('success', 'Personage image deleted successfully');
            }
        } else {
            return redirect()->route('personageIndex')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }

        return redirect('personages/' . $id . '/edit');

    }
}
