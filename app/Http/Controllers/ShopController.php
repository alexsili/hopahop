<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $shops = Shop::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('shop.index')
            ->with('shops', $shops);
    }

    public function create()
    {
        return view('shop.create');
    }

    public function store(Request $request)
    {
        $rules['title'] = 'required|string|max:255';
        $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png|max:30000';
        $rules['url'] = 'required|string|max:255';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('shop/create')
                ->withErrors($validator)
                ->withInput();
        }

        $shop = new Shop();
        $shop->title = $request->get('title');
        $shop->url = $request->get('url');

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = str_replace(' ', '', $request->title) . '_' . 'image' . '.' . $extension;
            $request->file('image')->move('uploads/shop', $image);
            $shop->image = $image;
        }

        $shop->save();

        return redirect('/shop')->with('success', 'Shop article created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $shop = Shop::findOrFail($id);;

        if ($shop == null) {
            return redirect('/shop')->with('error', 'Shop article not found!');
        }

        return view('shop.edit')
            ->with('shop', $shop);
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
        $shop = Shop::find($id);

        $rules['title'] = 'required|string|max:255';
        $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png|max:30000';
        $rules['url'] = 'required|string|max:255';

        if ($shop->image == null) {
            $rules['image'] = 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        } else {
            $rules['image'] = 'mimes:jpeg,jpg,bmp,png,pdf,doc,docx|max:30000';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('shop/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $shop->title = $request->get('title');
        $shop->url = $request->get('url');

        if ($request->hasFile('image')) {
            if (file_exists(public_path('uploads/shop/' . $shop->image . '')) && !empty($shop->image)) {
                unlink(public_path('uploads/shop/' . $shop->image . ''));
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = str_replace(' ', '-', $request->title) . '_' . 'image' . '.' . $extension;
            $request->file('image')->move('uploads/shop', $image);
            $shop->image = $image;
        }

        $shop->save();

        return redirect('/shop')->with('success', 'Article updated successfully.');
    }

    public function deleteShopArticle($id)
    {
        if (Auth::user()->isAdmin()) { // only admin can delete users
            $shop = Shop::findOrFail($id);;

            if ($shop) {
                $shop->delete();
                return redirect()->route('shopIndex')
                    ->with('success', 'Shop article deleted successfully');
            }
        } else {
            return redirect()->route('shopIndex')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }

        return redirect()->route('shopIndex');

    }


    public function deleteShopArticleImage($id)
    {

        if (Auth::user()->isAdmin()) { // only admin can delete users
            $shop = Shop::findOrFail($id);;

            if ($shop->image) {
                if (file_exists(public_path('uploads/shop/' . $shop->image . ''))) {
                    unlink(public_path('uploads/shop/' . $shop->image . ''));
                }
                $shop->image = null;
                $shop->save();
                return redirect()->route('shopIndex')
                    ->with('success', 'Shop article deleted successfully');
            }
        } else {
            return redirect()->route('shopIndex')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }

        return redirect('shop/' . $id . '/edit');

    }
}
