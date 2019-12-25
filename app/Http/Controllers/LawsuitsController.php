<?php

namespace App\Http\Controllers;

use App\Models\Lawsuit;
use App\Http\Resources\Lawsuit as LawsuitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LawsuitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawsuits = Lawsuit::all()->map(function ($lawsuit) {
            return new LawsuitResource($lawsuit);
        })->toJson();

        return view('content.cases.index', ['cases' => $lawsuits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function show(Cases $cases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function edit(Cases $cases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function update(Request $request, Cases $cases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function destroy(Cases $cases)
    {
        //
    }
}
