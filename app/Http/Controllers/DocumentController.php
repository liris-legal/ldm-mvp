<?php

namespace App\Http\Controllers;

use App\Models\Lawsuit;
use App\Models\Document;
use App\Models\Submitter;
use App\Models\TypeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
     * @param Lawsuit $lawsuit
     * @return void
     */
    public function create(Lawsuit $lawsuit)
    {
        $typeDocuments = TypeDocument::all();

        $submitters = Submitter::where('description', 'NOT LIKE', '%representative');
        $parties = Helpers::parseParties($lawsuit, $submitters);

        return view('content.documents.create', [
            'lawsuitId' => $lawsuit->id,
            'typeDocuments' => $typeDocuments,
            'submitters' => $parties
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lawsuit $lawsuit
     * @param $documentId
     * @return \Illuminate\Http\Response
     */
    public function edit(Lawsuit $lawsuit, $documentId)
    {
        $typeDocuments = TypeDocument::all();

        $submitters = Submitter::where('description', 'NOT LIKE', '%representative');
        $parties = Helpers::parseParties($lawsuit, $submitters);

        return view('content.documents.edit', [
                'lawsuitId' => $lawsuit->id,
                'documentId' => $documentId,
                'typeDocuments' => $typeDocuments,
                'submitters' => $parties
            ]);
    }
}
