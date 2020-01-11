<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Document as DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocument;
use Storage;

class DocumentApiController extends Controller
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
     * Display the specified resource.
     *
     * @param Document $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return response([
            'data' => new DocumentResource($document)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDocument $request)
    {
        $data = $request->all();
        $file = $request->file('file');
        $fileName = str_replace(' ', '-', $file->getClientOriginalName());
        $filenameHash = substr(hash('md5', date("mdYhms")), 0, 10) . '-' . $fileName;
        $filePath = '/uploads/documents/' . $filenameHash;
        Storage::put($filePath, file_get_contents($file), 'public');
        $data['url'] = $filenameHash;

        Document::create($data);

        $message = ['status' => 'success', 'content' => 'ファイルをアップロードしました。'];
        return response()->json([
            'url' => route('lawsuits.show', $data['lawsuit_id']),
            'message' => $message
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
