<?php

namespace App\Http\Controllers;

use App\Models\RatingFeedback;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class RatingFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('rating_feedback_read');

        return view('admin.rating-feedback.index', [
            'ratings_feedback' => RatingFeedback::orderBy('order')->get(),
            'attributes' => ['title', 'typeLabel', 'statusLabel', 'createdReadable'],
            'headers' => [
                __('common.title'),
                __('common.type'),
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
        isAllowedTo('rating_feedback_create');

        return view('admin.rating-feedback.create', [
            'types' => (new RatingFeedback())->getTypes()
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
        isAllowedTo('diseases_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (RatingFeedback::create($request->all())) {
            return redirect(route('rating-feedback.index'))->with('success', __('rating-feedback.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RatingFeedback  $ratingFeedback
     * @return \Illuminate\Http\Response
     */
    public function show(RatingFeedback $ratingFeedback)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RatingFeedback  $ratingFeedback
     * @return \Illuminate\Http\Response
     */
    public function edit(RatingFeedback $ratingFeedback)
    {
        isAllowedTo('rating_feedback_update');

        return view('admin.rating-feedback.edit', [
            'ratingFeedback' => $ratingFeedback,
            'types' => $ratingFeedback->getTypes()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RatingFeedback  $ratingFeedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RatingFeedback $ratingFeedback)
    {
        isAllowedTo('rating_feedback_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $ratingFeedback->fill($request->all());

        if ($ratingFeedback->update()) {
            return $this->makeResponse('rating-feedback.index', ['success', __('rating-feedback.updated_success'), Response::HTTP_OK]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RatingFeedback  $ratingFeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(RatingFeedback $ratingFeedback)
    {
        isAllowedTo('rating_feedback_delete');

        if (!$ratingFeedback->canBeDeleted()) {
            return back()->with('error', __('rating-feedback.cant_delete'));
        }

        $ratingFeedback->delete();

        return redirect(route('rating-feedback.index'))->with('success', __('rating-feedback.deleted_success'));
    }

    public function sort(Request $request)
    {
        foreach ($request->models as $model) {
            RatingFeedback::sort($model['id'], $model['order']);
        }

        return Response::HTTP_OK;
    }
}
