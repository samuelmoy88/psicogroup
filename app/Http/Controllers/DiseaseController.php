<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('diseases_read');

        return view('admin.diseases.index', [
            'diseases' => Disease::orderBy('order')->get(),
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
        isAllowedTo('diseases_create');

        return view('admin.diseases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('diseases_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (Disease::create($request->all())) {
            return redirect(route('diseases.index'))->with('success', __('diseases.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function show(Disease $disease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function edit(Disease $disease)
    {
        isAllowedTo('diseases_update');

        return view('admin.diseases.edit', [
            'disease' => $disease
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disease $disease)
    {
        isAllowedTo('diseases_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $disease->fill($request->all());

        if ($disease->update()) {
            $this->makeResponse('diseases.index', ['success', __('diseases.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disease $disease)
    {
        isAllowedTo('diseases_delete');

        $disease->delete();

        return redirect(route('diseases.index'))->with('success', __('diseases.deleted_success'));
    }
}
