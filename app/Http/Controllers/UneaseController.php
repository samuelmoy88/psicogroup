<?php

namespace App\Http\Controllers;

use App\Models\Unease;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UneaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('uneasiness_read');

        return view('admin.uneasiness.index', [
            'uneasiness' => Unease::orderBy('order')->get(),
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
        isAllowedTo('uneasiness_create');

        return view('admin.uneasiness.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('uneasiness_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (Unease::create($request->all())) {
            return redirect(route('uneasiness.index'))->with('success', __('uneasiness.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unease  $unease
     * @return \Illuminate\Http\Response
     */
    public function show(Unease $unease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Unease $uneasiness
     * @return \Illuminate\Http\Response
     */
    public function edit(Unease $uneasiness)
    {
        isAllowedTo('uneasiness_update');

        return view('admin.uneasiness.edit', [
            'unease' => $uneasiness
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unease  $uneasiness
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unease $uneasiness)
    {
        isAllowedTo('uneasiness_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $uneasiness->fill($request->all());

        if ($uneasiness->update()) {
            return $this->makeResponse('uneasiness.index', ['success', __('uneasiness.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unease  $uneasiness
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unease $uneasiness)
    {
        isAllowedTo('uneasiness_delete');

        $uneasiness->delete();

        return redirect(route('uneasiness.index'))->with('success', __('uneasiness.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            Unease::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
