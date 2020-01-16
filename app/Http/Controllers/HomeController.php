<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Resources\Document as DocumentResource;

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
        $documents = Document::all()->map(function ($document) {
            return new DocumentResource($document);
        });

        return view('content.home', ['documents' => $documents]);
    }

    /**
     * Pdf viewer in the iframe
     *
     * @param $src
     * @return Renderable
     */
    public function show($src)
    {
        return view('content.iframe.pdf-viewer');
    }
}
