<?php

namespace App\Http\Controllers;

use App\Models\OnlineConsultationPlatform;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlineConsultationPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('online_platform_read');

        return view('admin.online-platforms.index', [
            'onlinePlatforms' => OnlineConsultationPlatform::orderBy('order')->get(),
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
        isAllowedTo('online_platform_create');

        return view('admin.online-platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('online_platform_create');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (OnlineConsultationPlatform::create($request->all())) {
            return redirect(route('online-platforms.index'))->with('success', __('online-platforms.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param OnlineConsultationPlatform $onlinePlatforms
     * @return \Illuminate\Http\Response
     */
    public function show(OnlineConsultationPlatform $onlinePlatforms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param OnlineConsultationPlatform $onlinePlatform
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineConsultationPlatform $onlinePlatform)
    {
        isAllowedTo('online_platform_update');

        return view('admin.online-platforms.edit', [
            'onlinePlatform' => $onlinePlatform
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param OnlineConsultationPlatform $onlinePlatform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OnlineConsultationPlatform $onlinePlatform)
    {
        isAllowedTo('online_platform_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $onlinePlatform->fill($request->all());

        if ($onlinePlatform->update()) {
            return $this->makeResponse('online-platforms.index', ['success', __('online-platforms.updated_success')], Response::HTTP_OK);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OnlineConsultationPlatform $onlinePlatform
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(OnlineConsultationPlatform $onlinePlatform)
    {
        isAllowedTo('online_platform_delete');

        $onlinePlatform->delete();

        return redirect(route('online-platforms.index'))->with('success', __('online-platforms.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            OnlineConsultationPlatform::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
