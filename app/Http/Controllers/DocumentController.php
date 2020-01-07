<?php

namespace App\Http\Controllers;

use App\Models\Submitter;
use App\Models\TypeDocument;
use Illuminate\Http\Request;

class DocumentController extends Controller
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
     * @param $lawsuitId
     * @return void
     */
    public function create($lawsuitId)
    {
        $typeDocuments = TypeDocument::all();
        $submitters = Submitter::all();

        return view('content.documents.create', [
            'lawsuitId' => $lawsuitId,
            'typeDocuments' => $typeDocuments,
            'submitters' => $submitters
        ]);
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
}
