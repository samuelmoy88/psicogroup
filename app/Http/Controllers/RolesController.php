<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('roles_read');

        return view('admin.roles.index',[
            'roles' => Role::latest('created_at')->paginate(config('app.per_page')),
            'attributes' => ['name', 'createdReadable', 'actions'],
            'headers' => [
                __('common.name'),
                __('common.created_at'),
                __('common.actions'),
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
        isAllowedTo('roles_create');

        return view('admin.roles.create',[
            'permissions' => Permission::all(),
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
        isAllowedTo('roles_create');

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = Role::create([
            'name' =>  $request->name
        ]);

        if ($request->permissions) {
            foreach ($request->permissions as $id => $value) {
                if ($value) {
                    $role->givePermissionTo($id);
                }
            }
        }

        $role->save();

        return redirect(route('config.roles.index'))->with('success', __('config.role_updated_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        isAllowedTo('roles_update');

        return view('admin.roles.edit',[
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        isAllowedTo('roles_update');

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role->name = $request->name;

        foreach ($request->permissions as $id => $value) {
            if ($value != '0' && !$role->hasPermissionTo($id)) {
                $role->givePermissionTo($id);
            }

            if ($value == '0' && $role->hasPermissionTo($id)) {
                $role->revokePermissionTo($id);
            }
        }

        $role->save();

        return redirect(route('config.roles.index'))->with('success', __('config.role_updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        isAllowedTo('roles_delete');

        $role->delete();

        return redirect(route('config.roles.index'))->with('success', __('config.role_deleted_success'));
    }
}
