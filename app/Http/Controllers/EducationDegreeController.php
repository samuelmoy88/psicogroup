<?php

namespace App\Http\Controllers;

use App\Models\EducationDegree;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EducationDegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('education_degree_read');

        return view('admin.education-degree.index', [
            'education_degree' => EducationDegree::orderBy('order')->get(),
            'attributes' => ['name', 'statusLabel', 'createdReadable'],
            'headers' => [
                __('common.name'),
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
        isAllowedTo('education_degree_create');

        return view('admin.education-degree.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('education_degree_update');

        $request->validate([
            'name' => 'required|max:255|string'
        ]);

        if (EducationDegree::create($request->all())) {
            return redirect(route('education-degree.index'))->with('success', __('education-degree.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationDegree  $educationDegree
     * @return \Illuminate\Http\Response
     */
    public function show(EducationDegree $educationDegree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationDegree  $educationDegree
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationDegree $educationDegree)
    {
        isAllowedTo('education_degree_update');

        return view('admin.education-degree.edit', [
            'education_degree' => $educationDegree
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationDegree  $educationDegree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationDegree $educationDegree)
    {
        isAllowedTo('education_degree_update');

        $request->validate([
            'name' => 'required|max:255|string'
        ]);

        $educationDegree->fill($request->all());

        if ($educationDegree->update()) {
            return $this->makeResponse('education-degree.index', ['success', __('education-degree.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationDegree  $educationDegree
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationDegree $educationDegree)
    {
        isAllowedTo('social_media_delete');

        if (!$educationDegree->educations->isEmpty()) {
            return redirect(route('education-degree.index'))->with('error', __('education-degree.deleted_error_not_empty'));
        }

        $educationDegree->delete();

        return redirect(route('education-degree.index'))->with('success', __('education-degree.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            EducationDegree::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
