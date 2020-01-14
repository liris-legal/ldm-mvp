<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Document as DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\UpdateDocument;
use App\Models\Submitter;
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
        // dd($request->all());
        $documents = Document::where([
            ['number', $request['number']],
            ['type_document_id', $request['type_document_id']],
            ['submitter_id', $request['submitter_id']],
            ['lawsuit_id', $request['lawsuit_id'],
            ['id', '!=', $request['id']]]
        ])->get();
        if (($request['submitter_id'] == 1 || $request['submitter_id'] == 3) && $request['type_document_id'] == 2) {
            if ($documents) {
                return $request->validate([
                    'number'    =>  'unique:documents,number'
                ]);
            }
        }

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
    public function update(UpdateDocument $request, Document $document)
    {
        dd($document);
        $documents = Document::where([
            ['number', $request['number']],
            ['type_document_id', $request['type_document_id']],
            ['submitter_id', $request['submitter_id']],
            ['lawsuit_id', $request['lawsuit_id']],
            ['id', '!=', $document->id]
        ])->get();
        if (($request['submitter_id'] == 1 || $request['submitter_id'] == 3) && $request['type_document_id'] == 2) {
            if ($documents) {
                return $request->validate([
                    'number'    =>  'unique:documents,number'
                ]);
            }
        }

        $data = $request->all();
        $document->timestamps = true;
        $document->fill($data)->save();

        $message = ['status' => 'success', 'content' => '文書が正常に更新します。'];
        $submitter = Submitter::findOrFail($data['submitter_id']);

        if ($submitter->description == 'plaintiff' || $submitter->description == 'defendant') {
            return response()->json([
                'url' => route('documents.index', [$data['lawsuit_id'], $submitter->description]),
                'message' => $message
            ], 200);
        }
        return response()->json([
            'url' => route('lawsuits.show', $data['lawsuit_id']),
            'message' => $message
        ], 200);
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
