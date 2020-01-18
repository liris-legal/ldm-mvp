<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreDocument;
use App\Http\Resources\Document as DocumentResource;
use App\Http\Resources\DocumentUrl as DocumentUrlResource;
use App\Models\Defendant;
use App\Models\Document;
use App\Models\Plaintiff;
use App\Models\Submitter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDocument;
use App\Services\FileService;

class DocumentApiController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $lawsuitId
     * @return \Illuminate\Http\Response
     */
    public function index($lawsuitId)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $lawsuit
     * @param Document $document
     * @return \Illuminate\Http\Response
     */
    public function show($lawsuit, $document)
    {
        $document = Document::where('id', $document)->where('lawsuit_id', $lawsuit)->first();
        return response([
            'data' => new DocumentResource($document)
        ]);
    }

    /**
     * Display the Url of specified resource.
     *
     * @param $lawsuit
     * @param Document $document
     * @return \Illuminate\Http\Response
     */
    public function showUrl($lawsuit, $document)
    {
        $document = Document::where('id', $document)->where('lawsuit_id', $lawsuit)->first();
        return response([
            'data' => new DocumentUrlResource($document)
        ]);
    }

    /**
     * Create new resource.
     *
     * @param $data
     * @return Document
     */
    public function create($data)
    {
        // init document
        $document = new Document();
        $document->number = $data['number'];
        $document->name = $data['name'];
        $document->url = $data['url'];
        $document->lawsuit_id = $data['lawsuit_id'];
        $document->type_document_id = $data['type_document_id'];
        $document->submitter_id = $data['submitter_id'];
        $document->created_at = Carbon::parse($data['created_at']);

        $typeSubmitterId = $data['type_submitter_id'];
        $submitterId = $data['submitter_id'];
        switch ($submitterId) {
            case 1:
                Plaintiff::find($typeSubmitterId)->documents()->save($document);
                break;
            case 3:
                Defendant::find($typeSubmitterId)->documents()->save($document);
                break;
            default:
                Submitter::find($submitterId)->documents()->save($document);
        }
        return $document;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDocument $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDocument $request)
    {
        $data = $request->all();
        // storage file on aws-s3
        $data['url'] = $this->fileService->createFileS3($request, 'file');

        // create new document
        $this->create($data);

        $message = ['status' => 'success', 'content' => 'ファイルをアップロードしました。'];
        return response()->json([
            'url' => route('lawsuits.show', $data['lawsuit_id']),
            'message' => $message
        ], 200);
    }

    /**
     * Create new resource.
     *
     * @param $document
     * @param $request
     * @return Document
     */
    public function createOrUpdate($document, $request)
    {
        $data = $request->all();
        // If changed submitter
        if ($document->submitter_id !== (int)$request->submitter_id
            && $document->documentable_id !== $request->type_submitter_id) {
                // dd('recreating');
                // delete document and recreate document
                $data['url'] = $document->url;
                $document->delete();
                return $this->create($data);

        }
        // dd('updating');
        $document->updated_at = now();
        $document->fill($data)->save();
        return $document;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDocument $request
     * @param Document $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDocument $request, Document $document)
    {
        $this->createOrUpdate($document, $request);

        $message = ['status' => 'success', 'content' => '文書が正常に更新しました。'];
        $url = $document->submitter_id == 1 || $document->submitter_id == 3 ?
            route('documents.index', [$document->lawsuit_id, $document->submitter->description]) :
            route('lawsuits.show', $document->lawsuit_id);

        return response()->json(['url' => $url, 'message' => $message], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Document $document
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Document $document)
    {
        $this->fileService->deleteFileS3($document->url);
        $document->delete();

        $url = ($document->submitter_id == 1 || $document->submitter_id == 3) && ($document->type_document_id == 2) ?
            route('documents.index', [$document->lawsuit_id, $document->submitter->description]) :
            route('lawsuits.show', $document['lawsuit_id']);

        $message = ['status' => 'success', 'content' => 'ドキュメントは削除されました。'];
        return response()->json(['url' => $url, 'message' => $message], 200);
    }
}
