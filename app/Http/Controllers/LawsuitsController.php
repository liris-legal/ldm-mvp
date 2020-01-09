<?php

namespace App\Http\Controllers;

use App\Models\Lawsuit;
use App\Models\TypeLawsuit;
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
        return view('content.lawsuits.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $typeLawsuits = TypeLawsuit::all();
        return view('content.lawsuits.create', [ 'typeLawsuits' => $typeLawsuits]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $lawsuitId
     * @return void
     */
    public function edit($lawsuitId)
    {
        $typeLawsuits = TypeLawsuit::all();

        return view('content.lawsuits.edit')->with(['typeLawsuits' => $typeLawsuits, 'lawsuitId' => $lawsuitId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $lawsuitId
     * @return Response
     */
    public function show($lawsuitId)
    {
        return view('content.lawsuits.show')->with(['lawsuitId' => $lawsuitId]);
    }
}
