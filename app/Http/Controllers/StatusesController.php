<?php

namespace App\Http\Controllers;

use App\Diligencia;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get statuses percentages ( amount of calls of each status)
     *
     * @return mixed
     */
    public function getStatusesPercentages()
    {
        $statuses = Status::all();

        $diligencias = Diligencia::all();

        $total_diligencias = $diligencias->count();

        $calls_percentages = [];

        // Group calls based on status
        foreach($statuses as $status) {
            $filtered_calls_of_this_status = $diligencias->filter(function($item) use ($status) {
                return $item->status_id == $status->id;
            });

            // Count the calls of this status
            $calls_percentages[$status->slug] = $filtered_calls_of_this_status->count();

            if ($total_diligencias == 0)
                $calls_percentages[$status->slug] = 0;
            else
                // Percentage
                $calls_percentages[$status->slug] = $calls_percentages[$status->slug] * 100 / $total_diligencias;
        }

        return Response::json($calls_percentages);
    }
}
