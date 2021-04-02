<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('users_read');

        return view('admin.users.index',[
            'admins' => User::with('roles')->where('profile_type', AdminProfile::class)->latest('created_at','DESC')->paginate(config('app.per_page')),
            'attributes' => ['first_name','last_names', 'email', 'role','createdReadable'],
            'headers' => [
                __('common.first_name'),
                __('common.last_names'),
                __('common.email'),
                __('common.phone'),
                __('common.roles'),
                __('common.created_at'),
                __('common.actions')
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        isAllowedTo('users_create');

        return view('admin.users.create',[
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('users_create');

        $request->validate([
            'first_name' => 'required|max:255',
            'email' => 'required|email:filter|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone'
        ]);

        (new AdminProfile())->add($request);

        return redirect(route('config.users.index'))->with('success', __('config.user_created_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        isAllowedTo('users_read');

        return view('admin.users.show',[
            'user' => $user,
            'roles' => Role::all(),
            'statuses' => [
                User::STATUS_ACTIVE, User::STATUS_INACTIVE
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        isAllowedTo('users_update');

        return view('admin.users.edit',[
            'user' => $user,
            'roles' => Role::all(),
            'statuses' => [
                User::STATUS_ACTIVE, User::STATUS_INACTIVE
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        isAllowedTo('users_update');

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email:filter|unique:users,email,'.$user->id,
            'phone' => 'required|numeric|unique:users,phone,'.$user->id,
        ]);

        $user->profile->edit($request);

        return redirect(route('config.users.index'))->with('success', __('config.user_updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        isAllowedTo('users_delete');

        $user->delete();

        return redirect(route('config.users.index'))->with('success', __('config.user_deleted_success'));
    }
}
