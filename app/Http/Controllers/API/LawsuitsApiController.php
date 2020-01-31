<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DocumentUrl as DocumentUrlResource;
use App\Http\Resources\Lawsuit as LawsuitResource;
use App\Models\Lawsuit;
use App\Models\Submitter;
use App\Http\Requests\StoreLawsuit;
use App\Models\OtherParty;
use App\Models\Plaintiff;
use App\Models\PlaintiffRepresentative;
use App\Models\Defendant;
use App\Models\DefendantRepresentative;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\FileService;

class LawsuitsApiController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'data' => Lawsuit::all()->map(function ($lawsuit) {
                return new LawsuitResource($lawsuit);
            })
        ]);
    }

    /**
     * Store a newly created party.
     *
     * @param Request $request
     * @param $submitterId
     * @param $lawsuit
     * @param $party
     * @param $model
     */
    public function storeParties(Request $request, $submitterId, $lawsuit, $party, $model)
    {
        if ($request->has($party)) {
            foreach ($request->get($party) as $item) {
                $data = ['name' => $item, 'submitter_id' => $submitterId, 'lawsuit_id' => $lawsuit->id];
                $class = "App\Models\\".$model;
                $class::create($data);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLawsuit $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLawsuit $request)
    {
        $data = $request->all();
        $data['created_at'] = now();
        $lawsuit = Lawsuit::create($data);

        $submitterPlaintiffId = Submitter::where('description', 'plaintiff')->value('id');
        $this->storeParties($request, $submitterPlaintiffId, $lawsuit, 'plaintiffs', 'Plaintiff');
        $this->storeParties(
            $request,
            $submitterPlaintiffId,
            $lawsuit,
            'plaintiff_representatives',
            'PlaintiffRepresentative'
        );
        $submitterDefendantId = Submitter::where('description', 'defendant')->value('id');
        $this->storeParties($request, $submitterDefendantId, $lawsuit, 'defendants', 'Defendant');
        $this->storeParties(
            $request,
            $submitterDefendantId,
            $lawsuit,
            'defendant_representatives',
            'DefendantRepresentative'
        );
        $submitterOtherId = Submitter::where('description', 'other_party')->value('id');
        $this->storeParties($request, $submitterOtherId, $lawsuit, 'other_parties', 'OtherParty');

        $message = ['status' => 'success', 'content' => '事件を作成しました。'];

        return response()->json(['url' => route('lawsuits.index'), 'message' => $message], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Lawsuit $lawsuit
     * @return \Illuminate\Http\Response
     */
    public function show(Lawsuit $lawsuit)
    {
        return response([
            'data' => new LawsuitResource($lawsuit)
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
     * Update the specified resource party.
     *
     * @param Request $request
     * @param $submitter
     * @param $lawsuit
     * @param $partyMethod
     * @param $party
     * @param $model
     */
    public function updateParties(Request $request, $submitter, $lawsuit, $partyMethod, $party, $model)
    {
        $lawsuit->$partyMethod()->delete();
        $this->storeParties($request, $submitter, $lawsuit, $party, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreLawsuit $request
     * @param Lawsuit $lawsuit
     * @return JsonResponse
     */
    public function update(StoreLawsuit $request, Lawsuit $lawsuit)
    {
        $data = $request->all();
        $data['updated_at'] = now();
        $lawsuit->fill($data)->save();
        // $lawsuit->update($data);

        $submitters = Submitter::all();
        $this->updateParties($request, $submitters[0], $lawsuit, 'plaintiffs', 'plaintiffs', 'Plaintiff');
        $this->updateParties(
            $request,
            $submitters[0],
            $lawsuit,
            'plaintiffRepresentatives',
            'plaintiff_representatives',
            'PlaintiffRepresentative'
        );
        $this->updateParties($request, $submitters[1], $lawsuit, 'defendants', 'defendants', 'Defendant');
        $this->updateParties(
            $request,
            $submitters[1],
            $lawsuit,
            'defendantRepresentatives',
            'defendant_representatives',
            'DefendantRepresentative'
        );
        $this->updateParties($request, $submitters[3], $lawsuit, 'otherParties', 'other_parties', 'OtherParty');

        $message = ['status' => 'success', 'content' => '事件を編集しました。'];
        return response()->json(['url' => route('lawsuits.index'), 'message' => $message], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lawsuit $lawsuit
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Lawsuit $lawsuit)
    {
        $documents = Document::where('lawsuit_id', $lawsuit->id)->get();
        $documents->map(function ($document) {
            $this->fileService->deleteFileS3($document);
        });
        $lawsuit->delete();

        $message = ['status' => 'success', 'content' => '事件を削除しました。'];
        return response()->json(['url'=> route('lawsuits.index'), 'message' => $message], 200);
    }
}
