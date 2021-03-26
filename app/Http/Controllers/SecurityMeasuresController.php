<?php

namespace App\Http\Controllers;

use App\Models\SecurityMeasures;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityMeasuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('security_measures_read');

        return view('admin.security-measures.index', [
            'securityMeasures' => SecurityMeasures::orderBy('order')->get(),
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
        isAllowedTo('security_measures_create');

        return view('admin.security-measures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('security_measures_create');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (SecurityMeasures::create($request->all())) {
            return redirect(route('security-measures.index'))->with('success', __('security-measures.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SecurityMeasures  $securityMeasures
     * @return \Illuminate\Http\Response
     */
    public function show(SecurityMeasures $securityMeasures)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SecurityMeasures  $securityMeasure
     * @return \Illuminate\Http\Response
     */
    public function edit(SecurityMeasures $securityMeasure)
    {
        isAllowedTo('security_measures_update');

        return view('admin.security-measures.edit', [
            'securityMeasure' => $securityMeasure
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SecurityMeasures  $securityMeasures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SecurityMeasures $securityMeasure)
    {
        isAllowedTo('security_measures_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $securityMeasure->fill($request->all());

        if ($securityMeasure->update()) {
            $this->makeResponse('security-measures.index', ['success', __('security-measures.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SecurityMeasures  $securityMeasure
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecurityMeasures $securityMeasure)
    {
        isAllowedTo('security_measures_delete');

        $securityMeasure->delete();

        return redirect(route('security-measures.index'))->with('success', __('security-measures.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            SecurityMeasures::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
