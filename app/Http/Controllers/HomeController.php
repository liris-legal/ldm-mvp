<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\CategoryCase;
use App\Models\Document;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

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
        $documents = Document::all();
        return view('content.home', ['documents' => $documents]);
    }

    /**
     * Show the application folders.
     *
     * @return Renderable
     */
    public function folder()
    {
        $folders = CategoryCase::all();
        return view('content.folders.index', ['folders' => $folders]);
    }

    /**
     * Show the application cases.
     *
     * @return Renderable
     */
    public function cases()
    {
        $cases = Cases::all();
        return view('content.cases.index', ['cases' => $cases]);
    }
}
