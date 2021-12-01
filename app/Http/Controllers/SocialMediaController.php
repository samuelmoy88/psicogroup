<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('social_media_read');

        return view('admin.social-media.index', [
            'social_media' => SocialMedia::orderBy('order')->get(),
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
        isAllowedTo('social_media_create');

        return view('admin.social-media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('social_media_update');

        $request->validate([
            'name' => 'required|max:255|string'
        ]);

        if (SocialMedia::create($request->all())) {
            return redirect(route('social-media.index'))->with('success', __('social-media.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param SocialMedia $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function show(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SocialMedia $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialMedia $socialMedia)
    {
        isAllowedTo('social_media_update');

        return view('admin.social-media.edit', [
            'social_media' => $socialMedia
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param SocialMedia $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialMedia $socialMedia)
    {
        isAllowedTo('social_media_update');

        $request->validate([
            'name' => 'required|max:255|string'
        ]);

        $socialMedia->fill($request->all());

        if ($socialMedia->update()) {
            return $this->makeResponse('social-media.index', ['success', __('social-media.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SocialMedia $socialMedia
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(SocialMedia $socialMedia)
    {
        isAllowedTo('social_media_delete');

        $socialMedia->delete();

        return redirect(route('social-media.index'))->with('success', __('social-media.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            SocialMedia::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
