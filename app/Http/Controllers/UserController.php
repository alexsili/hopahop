<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('warning', 'Sorry! You are not authorized to access this page');
        }

        $users = User::orderBy('first_name')->orderBy('last_name')->get();

        return view('user.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('warning', 'Sorry! You are not authorized to access this page');
        }
        $user = new User();
        $countries = Country::pluck('name', 'id')->toArray();

        return view('user.create')
            ->with('countries', $countries)
            ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('warning', 'Sorry! You are not authorized to access this page');
        }

        $rules['first_name'] = 'required|string|max:255';
        $rules['last_name'] = 'required|string|max:255';
        $rules['country'] = 'required|string|max:255';
        $rules['userTypeAdmin'] = 'required_without_all:userTypeModerator,userTypeUsual';
        $rules['userTypeModerator'] = 'required_without_all:userTypeAdmin,userTypeUsual';
        $rules['userTypeUsual'] = 'required_without_all:userTypeAdmin,userTypeModerator';
        $rules['email'] = 'required|email|unique:users,email,' . 0;
        $rules['password'] = 'sometimes|min:8|confirmed'; // required only if not empty;
        $rules['password_confirmation'] = 'sometimes|min:8';

        $userRole = implode(",", array_filter([$request->get('userTypeAdmin') ?? '', $request->get('userTypeModerator') ?? '', $request->get('userTypeUsual') ?? '']));

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('users/create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->roles = $userRole;
        $user->country_id = $request->get('country');
        $user->status = $request->get('status');
        $user->password = bcrypt($request->get('password'));
        $user->save();

        return redirect('/users')->with('success', 'User created successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($hash)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('warning', 'Sorry! You are not authorized to access this page');
        }

        $countries = Country::pluck('name', 'id')->toArray();
        $user = User::where(DB::raw("MD5(id)"), $hash)->first();

        if (!$user) {
            return redirect('user')->with('error', 'User not found!');
        }

        return view('user.edit')
            ->with('countries', $countries)
            ->with('user', $user);
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
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('warning', 'Sorry! You are not authorized to access this page');
        }
        $rules['first_name'] = 'required|string|max:255';
        $rules['last_name'] = 'required|string|max:255';
        $rules['country'] = 'required|string|max:255';
        $rules['userTypeAdmin'] = 'required_without_all:userTypeModerator,userTypeUsual';
        $rules['userTypeModerator'] = 'required_without_all:userTypeAdmin,userTypeUsual';
        $rules['userTypeUsual'] = 'required_without_all:userTypeAdmin,userTypeModerator';
        $rules['email'] = 'required|email|unique:users,email,' . $id;

        if (!empty($request->get('password'))) {
            $rules['password'] = 'sometimes|min:8|confirmed'; // required only if not empty;
            $rules['password_confirmation'] = 'sometimes|min:8';
        }

        $userRole = implode(",", array_filter([$request->get('userTypeAdmin') ?? '', $request->get('userTypeModerator') ?? '', $request->get('userTypeUsual') ?? '']));

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('users/' . md5($id) . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);

        if (!empty($request->get('password'))) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->roles = $userRole;
        $user->country_id = $request->get('country');
        $user->status = $request->get('status');
        $user->save();

        return redirect('/users')->with('success', 'User updated successfully.');
    }

    /**
     * @param $hash
     * @return RedirectResponse
     */

    public function destroy($hash)
    {

        if (Auth::user()->isAdmin()) { // only admin can delete users
            $user = User::where(DB::raw("MD5(id)"), $hash)->first();

            if ($user) {
                $user->delete();
                return redirect()->route('users.index')
                    ->with('success', 'User deleted successfully');
            }
        } else {
            return redirect()->route('users.index')
                ->with('warning', 'You don\'t have permissions to delete this user');
        }


        return redirect()->route('users.index');
    }

    public function myAccount()
    {
        $countries = Country::pluck('name', 'id')->toArray();

        return view('user.account')
            ->with('countries', $countries)
            ->with('user', auth()->user());
    }

    public function accountUpdate(Request $request)
    {
        $countries = Country::pluck('name', 'id')->toArray();

        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->country_id = $request->country;
        $user->save();


        return view('user.account')
            ->with('countries', $countries)
            ->with('user', $user);
    }
}
