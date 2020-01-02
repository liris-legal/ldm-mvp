<?php

namespace App\Http\Controllers\API;

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

class LawsuitsApiController extends Controller
{
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
     * @param $submitter
     * @param $lawsuit
     * @param $party
     * @param $model
     */
    public function storeParties(Request $request, $submitter, $lawsuit, $party, $model)
    {
        foreach ($request->get($party) as $item) {
            $data = ['name' => $item, 'submitter_id' => $submitter->id, 'lawsuit_id' => $lawsuit->id];
            $class = "App\Models\\".$model;
            $class::create($data);
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

        $submitters = Submitter::all();
        $this->storeParties($request, $submitters[0], $lawsuit, 'plaintiffs', 'Plaintiff');
        $this->storeParties(
            $request,
            $submitters[0],
            $lawsuit,
            'plaintiff_representatives',
            'PlaintiffRepresentative'
        );
        $this->storeParties($request, $submitters[1], $lawsuit, 'defendants', 'Defendant');
        $this->storeParties(
            $request,
            $submitters[1],
            $lawsuit,
            'defendant_representatives',
            'DefendantRepresentative'
        );
        $this->storeParties($request, $submitters[3], $lawsuit, 'other_parties', 'OtherParty');

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $lawsuit->delete();

        $message = ['status' => 'success', 'content' => '事件を削除しました。'];
        return response()->json(['url'=> route('lawsuits.index'), 'message' => $message], 200);
    }
}