<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Submitter;
use App\Models\TypeDocument;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $lawsuitId
     * @param $submitter
     * @return \Illuminate\Http\Response
     */
    public function index($lawsuitId, $submitter)
    {
        return view('content.documents.index', ['lawsuitId' => $lawsuitId, 'submitter' => $submitter]);
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
        $submitters = Submitter::where('description', 'NOT LIKE', '%representative')->get();

        return view('content.documents.create', [
            'lawsuitId' => $lawsuitId,
            'typeDocuments' => $typeDocuments,
            'submitters' => $submitters
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $lawsuitId
     * @param $documentId
     * @return \Illuminate\Http\Response
     */
    public function edit($lawsuitId, $documentId)
    {
        $typeDocuments = TypeDocument::all();
        $submitters = Submitter::where('description', 'NOT LIKE', '%representative')->get();

        return view('content.documents.edit', [
                'lawsuitId' => $lawsuitId,
                'documentId' => $documentId,
                'typeDocuments' => $typeDocuments,
                'submitters' => $submitters
            ]);
    }
}
