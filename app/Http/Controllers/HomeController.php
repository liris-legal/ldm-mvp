<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Resources\Document as DocumentResource;
use Auth;

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
        $viewedDocuments = Auth::user()->recently_viewed_documents;
        $documents = empty($viewedDocuments) ? Document::all()->take(10)
            : Document::whereIn('id', array_slice(json_decode($viewedDocuments), 0, 10))->get();

        return view('content.home', ['documents' => $documents]);
    }

    /**
     * Pdf viewer in the iframe
     *
     * @param Request $request
     * @return Renderable
     */
    public function show(Request $request)
    {
        $src = $request->query('url', 'null');
        $documentId = Document::where('url', explode("documents/", $src)[1])->value('id');

        // update recently_viewed_documents
        $user = Auth::user();
        $documents = empty($user->recently_viewed_documents) ? [] : json_decode($user->recently_viewed_documents);
        array_push($documents, $documentId);
        $user->update(array('recently_viewed_documents' => array_values(array_unique($documents))));

        return view('content.iframe.pdf-viewer', ['src' => $src]);
    }
}
