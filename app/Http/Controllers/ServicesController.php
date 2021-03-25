<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('services_read');

        return view('admin.services.index', [
            'services' => Services::latest('updated_at')->paginate(config('app.per_page')),
            'attributes' => ['title', 'statusLabel', 'createdReadable'],
            'headers' => [
                __('common.title'),
                __('common.status'),
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
        isAllowedTo('services_create');

        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('services_create');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (Services::create($request->all())) {
            return redirect(route('services.index'))->with('success', __('services.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Services $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $service)
    {
        isAllowedTo('services_update');

        return view('admin.services.edit', [
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $service)
    {
        isAllowedTo('services_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $service->fill($request->all());

        if ($service->update()) {
            return redirect(route('services.index'))->with('success', __('services.updated_success'));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $service)
    {
        isAllowedTo('services_delete');

        $service->delete();

        return redirect(route('services.index'))->with('success', __('services.deleted_success'));
    }
}
