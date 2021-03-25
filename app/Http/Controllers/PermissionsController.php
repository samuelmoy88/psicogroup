<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('permissions_read');

        return view('admin.permissions.index',[
            'permissions' => Permission::latest('created_at')->paginate(config('app.per_page')),
            'attributes' => ['name', 'createdReadable'],
            'headers' => [
                __('common.name'),
                __('common.created_at'),
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
        isAllowedTo('permissions_create');

        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('permissions_create');

        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        Permission::create($request->all());

        return redirect(route('config.permissions.index'))->with('success', __('config.permission_created_success'));
    }
}
