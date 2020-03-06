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
use Auth;
use Illuminate\Support\Facades\DB;

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
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        return response([
            'data' => Lawsuit::where('user_id', $userId)->get()->map(function ($lawsuit) {
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
     * @param $userId
     * @param StoreLawsuit $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLawsuit $request, $userId)
    {
        $data = $request->all();
        $data['user_id'] = $userId;
        $data['created_at'] = now();
        $lawsuit = Lawsuit::create($data);

        $submitterPlaintiffId = $this->selectSubmitter('description', 'plaintiff', 'id');
        $this->storeParties($request, $submitterPlaintiffId, $lawsuit, 'plaintiffs', 'Plaintiff');
        $this->storeParties(
            $request,
            $submitterPlaintiffId,
            $lawsuit,
            'plaintiff_representatives',
            'PlaintiffRepresentative'
        );
        $submitterDefendantId = $this->selectSubmitter('description', 'defendant', 'id');
        $this->storeParties($request, $submitterDefendantId, $lawsuit, 'defendants', 'Defendant');
        $this->storeParties(
            $request,
            $submitterDefendantId,
            $lawsuit,
            'defendant_representatives',
            'DefendantRepresentative'
        );
        $submitterOtherId = $this->selectSubmitter('description', 'other_party', 'id');
        $this->storeParties($request, $submitterOtherId, $lawsuit, 'other_parties', 'OtherParty');

        $message = ['status' => 'success', 'content' => '事件を作成しました。'];

        return response()->json(['url' => route('lawsuits.index'), 'message' => $message], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $userId
     * @param $lawsuitId
     * @return \Illuminate\Http\Response
     */
    public function show($userId, $lawsuitId)
    {
        $lawsuit = Lawsuit::where(['user_id' => $userId, 'id' => $lawsuitId])->firstOrFail();
        return response([
            'data' => new LawsuitResource($lawsuit)
        ]);
    }

    /**
     * Display the Url of specified resource.
     *
     * @param $userId
     * @param $lawsuitId
     * @param $documentId
     * @return \Illuminate\Http\Response
     */
    public function showUrl($userId, $lawsuitId, $documentId)
    {
        $document = Document::where('id', $documentId)->where('lawsuit_id', $lawsuitId)->firstOrFail();
        return response([
            'data' => new DocumentUrlResource($document)
        ]);
    }

    /**
     * Update the specified resource party.
     *
     * @param Request $request
     * @param $submitterId
     * @param $lawsuit
     * @param $partyMethod
     * @param $party
     * @param $model
     */
    public function updateParties(Request $request, $submitterId, $lawsuit, $partyMethod, $party, $model)
    {
        // $lawsuit->$partyMethod()->delete();
        // $this->storeParties($request, $submitter, $lawsuit, $party, $model);
        if ($request->has($party)) {
            $ids = [];
            foreach ($request->get($party) as $item) {
                $itemObject = json_decode($item, true);
                // new data
                $data = ['name' => $itemObject['name'], 'submitter_id' => $submitterId, 'lawsuit_id' => $lawsuit->id];

                // init model
                $class = "App\Models\\".$model;

                // update or created new
                if (isset($itemObject['id'])) {
                    $class::updateOrCreate(['id' => $itemObject['id']], $data);
                    array_push($ids, $itemObject['id']);
                }
                if (!isset($itemObject['id'])) {
                    $newObj = $class::create($data);
                    array_push($ids, $newObj->id);
                }
            }

            // delete document of submitter is [plaintiffs/ defendants]
            if ($partyMethod === 'plaintiffs' || $partyMethod === 'defendants') {
                DB::table('documents')
                    ->where([
                        ['submitter_id', '=', $submitterId],
                        ['lawsuit_id', '=', $lawsuit->id],
                        ['documentable_type', '=',"App\Models\\".$model]
                    ])
                    ->whereNotIn('documentable_id', $ids)
                    ->delete();
            }

            // delete party not in $ids
            DB::table($party)->where('lawsuit_id', $lawsuit->id)->whereNotIn('id', $ids)->delete();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreLawsuit $request
     * @param $userId
     * @param Lawsuit $lawsuit
     * @return JsonResponse
     */
    public function update(StoreLawsuit $request, $userId, Lawsuit $lawsuit)
    {
        // $lawsuit = Lawsuit::where(['user_id' => $userId, 'id' => $lawsuitId])->first();
        if ($lawsuit->user_id !== (int)$userId) {
            $message = ['status' => 'error', 'content' => 'この事件を編集する権限がありません'];
            return response()->json(['url' => route('lawsuits.index'), 'message' => $message], 403);
        }

        $data = $request->all();
        $data['updated_at'] = now();
        $lawsuit->fill($data)->save();
        // $lawsuit->update($data);

        $submitterPlaintiffId = $this->selectSubmitter('description', 'plaintiff', 'id');
        $this->updateParties($request, $submitterPlaintiffId, $lawsuit, 'plaintiffs', 'plaintiffs', 'Plaintiff');
        $this->updateParties(
            $request,
            $submitterPlaintiffId,
            $lawsuit,
            'plaintiffRepresentatives',
            'plaintiff_representatives',
            'PlaintiffRepresentative'
        );

        $submitterDefendantId = $this->selectSubmitter('description', 'defendant', 'id');
        $this->updateParties($request, $submitterDefendantId, $lawsuit, 'defendants', 'defendants', 'Defendant');
        $this->updateParties(
            $request,
            $submitterDefendantId,
            $lawsuit,
            'defendantRepresentatives',
            'defendant_representatives',
            'DefendantRepresentative'
        );
        $submitterOtherId = $this->selectSubmitter('description', 'other_party', 'id');
        $this->updateParties($request, $submitterOtherId, $lawsuit, 'otherParties', 'other_parties', 'OtherParty');

        $message = ['status' => 'success', 'content' => '事件を編集しました。'];
        return response()->json(['url' => route('lawsuits.index'), 'message' => $message], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $userId
     * @param $lawsuitId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($userId, $lawsuitId)
    {
        $lawsuit = Lawsuit::where('id', $lawsuitId)->where('user_id', $userId)->firstOrFail();
        $documents = Document::where('lawsuit_id', $lawsuitId)->get();
        $documents->map(function ($document) {
            $this->fileService->deleteFileS3($document);
        });
        $lawsuit->delete();

        $message = ['status' => 'success', 'content' => '事件を削除しました。'];
        return response()->json(['url'=> route('lawsuits.index'), 'message' => $message], 200);
    }

    /**
     * Select field the specified resource submitter.
     *
     * @param $field
     * @param $condition
     * @param $value
     * @return Submitter
     */
    public function selectSubmitter($field, $condition, $value)
    {
        return Submitter::where($field, $condition)->value($value);
    }
}
