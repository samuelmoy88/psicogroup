<?php

namespace App\Http\Controllers;

use App\Models\RatingDispute;
use Illuminate\Http\Request;

class RatingDisputeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('dispute_read');

        return view('admin.rating-disputes.index', [
            'disputes' => RatingDispute::latest('created_at')->paginate(config('app.per_page')),
            'headers' => [
                __('common.specialist'),
                __('common.patient'),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RatingDispute  $dispute
     * @return \Illuminate\Http\Response
     */
    public function show(RatingDispute $dispute)
    {
        isAllowedTo('dispute_read');

        return view('admin.rating-disputes.show', [
            'dispute' => $dispute
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RatingDispute  $ratingDispute
     * @return \Illuminate\Http\Response
     */
    public function edit(RatingDispute $ratingDispute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RatingDispute  $ratingDispute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RatingDispute $ratingDispute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RatingDispute  $ratingDispute
     * @return \Illuminate\Http\Response
     */
    public function destroy(RatingDispute $ratingDispute)
    {
        //
    }
}
