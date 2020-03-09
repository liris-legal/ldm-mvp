<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentUrl;
use App\Http\Resources\DocumentUrl as DocumentUrlResource;
use App\Models\Document;
use App\Models\DocumentRecently;
use App\Services\FileService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        // get recently_viewed_documents
        $viewedDocuments = DocumentRecently::where('user_id', Auth::user()->id)->get();

        return view('content.home', ['documents' => $viewedDocuments]);
    }

    /**
     * Pdf viewer in the iframe
     *
     * @param Request $request
     * @param $lawsuitId
     * @param $documentId
     * @return Renderable
     */
    public function show(Request $request, $lawsuitId, $documentId)
    {
        $time = Carbon::now();
        $document = Document::where('id', $documentId)->where('lawsuit_id', $lawsuitId)->firstOrFail();

        // update recently_viewed_documents
        DocumentRecently::updateOrCreate(
            ['user_id' => Auth::user()->id, 'document_id' => $documentId, 'lawsuit_id' => $lawsuitId],
            [
                'type_document_id' => $document->type_document_id,
                'name' => $document->name,
                'number' => $document->number,
                'subnumber' => $document->subnumber,
                'created_at' => $time
            ]
        );

        $src = (new FileService())->getFileUrlS3($document->url);
        return view('content.iframe.pdf-viewer', ['src' => $src]);
    }
}
