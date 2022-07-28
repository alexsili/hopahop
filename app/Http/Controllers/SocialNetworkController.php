<?php

namespace App\Http\Controllers;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SocialNetworkController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $socialNetworks = SocialNetwork::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('social-network.index')
            ->with('socialNetworks', $socialNetworks);
    }

    public function create()
    {
        return view('social-network.create');
    }

    public function store(Request $request)
    {
        $rules['name'] = 'required|string|max:255';
        $rules['url'] = 'required|string|max:255';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('social-network/create')
                ->withErrors($validator)
                ->withInput();
        }

        $socialNetwork = new SocialNetwork();
        $socialNetwork->name = $request->get('name');
        $socialNetwork->url = $request->get('url');
        $socialNetwork->save();

        return redirect('/social-network')->with('success', 'Social network added successfully.');
    }


    public function edit($id)
    {
        $socialNetwork = SocialNetwork::where('id', $id)
            ->first();

        if ($socialNetwork == null) {
            return redirect('/social-network')->with('error', 'Social network not found!');
        }

        return view('social-network.edit')
            ->with('socialNetwork', $socialNetwork);
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

        $socialNetwork = SocialNetwork::find($id);

        $rules['name'] = 'required|string|max:255';
        $rules['url'] = 'required|string|max:255';


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('social-network/' . $socialNetwork . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $socialNetwork->name = $request->get('name');
        $socialNetwork->url = $request->get('url');
        $socialNetwork->save();

        return redirect('/social-network')->with('success', 'Social network updated successfully.');
    }

    public function deleteSocialNetwork($id)
    {
        if (Auth::user()->isAdmin()) { // only admin can delete users
            $socialNetwork = SocialNetwork::findOrFail($id);;

            if ($socialNetwork) {
                $socialNetwork->delete();
                return redirect('/social-network')
                    ->with('success', 'Social network deleted successfully');
            }
        } else {
            return redirect('/social-network')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }

        return redirect('/social-network');

    }


}
