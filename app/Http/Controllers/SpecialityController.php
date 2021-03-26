<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpecialityController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('specialities_read');

        return view('admin.specialities.index', [
            'specialities' => Speciality::orderBy('order')->get(),
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
        isAllowedTo('specialities_create');

        return view('admin.specialities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('specialities_create');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (Speciality::create($request->all())) {
            return redirect(route('specialities.index'))->with('success', __('specialities.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function show(Speciality $speciality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function edit(Speciality $speciality)
    {
        isAllowedTo('specialities_update');

        return view('admin.specialities.edit', [
            'speciality' => $speciality
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speciality $speciality)
    {
        isAllowedTo('specialities_read');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $speciality->fill($request->all());

        if ($speciality->update()) {
            return $this->makeResponse('specialities.index', ['success', __('specialities.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speciality $speciality)
    {
        isAllowedTo('specialities_delete');

        $speciality->delete();

        return redirect(route('specialities.index'))->with('success', __('specialities.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            Speciality::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
