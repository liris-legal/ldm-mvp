<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Document as DocumentResource;
use App\Models\Defendant;
use App\Models\Document;
use App\Models\Plaintiff;
use App\Models\Submitter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDocument;
use App\Http\Requests\StoreDocument;
use App\Services\FileService;

class DocumentApiController extends Controller
{
    /**
     * an instance FileService
     * @var string
     */
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
     * Create new Document resource.
     *
     * @param $data
     * @return Document
     */
    public function create($data)
    {
        // init document
        $document = new Document();
        $document->name = $data['name'];
        $document->number = $data['number'];
        $document->subnumber = $data['subnumber'];
        $document->url = $data['url'];
        $document->lawsuit_id = $data['lawsuit_id'];
        $document->type_document_id = $data['type_document_id'];
        $document->submitter_id = $data['submitter_id'];
        $document->created_at = \Carbon\Carbon::parse($data['created_at']);

        $typeSubmitterId = $data['type_submitter_id'];
        $submitterId = $data['submitter_id'];
        switch ($submitterId) {
            case 1:
                $party = Plaintiff::where('id', $typeSubmitterId)
                    ->where('lawsuit_id', $data['lawsuit_id'])->first();
                $party ? $party->documents()->save($document) :
                    Submitter::find($submitterId)->documents()->save($document);
                break;
            case 3:
                $party = Defendant::where('id', $typeSubmitterId)
                    ->where('lawsuit_id', $data['lawsuit_id'])->first();
                $party ? $party->documents()->save($document) :
                    Submitter::find($submitterId)->documents()->save($document);
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
     * Update the specified resource in storage.
     *
     * @param UpdateDocument $request
     * @param Document $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDocument $request, Document $document)
    {
        $data = $request->all();
        // If changed submitter
        $documentableId = $request->type_submitter_id;
        $submitterId = $request->submitter_id;
        if ($document->submitter_id !== $submitterId
            || $document->documentable_id !== $documentableId) {
            // dd('re-updating');
            switch ($submitterId) {
                case 1:
                    $documentableId == 0 ? $documentableId = $documentableType = null
                        : $documentableType = 'App\Models\Plaintiff';
                    break;
                case 3:
                    $documentableId == 0 ? $documentableId = $documentableType = null
                        : $documentableType = 'App\Models\Defendant';
                    break;
                default:
                    $documentableId = $documentableType = null;
                    break;
            }

            // re-update document
            $data['documentable_id'] = $documentableId;
            $data['documentable_type'] = $documentableType;
        }
        // dd('updating');
        $document->updated_at = now();
        $document->fill($data)->save();

        $message = ['status' => 'success', 'content' => '文書が正常に更新しました。'];
        $url = route('lawsuits.show', $document->lawsuit_id);

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
