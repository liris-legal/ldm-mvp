<?php

namespace App\Http\Controllers;

use App\Models\Lawsuit;
use App\Http\Resources\Lawsuit as LawsuitResource;
use App\Models\OtherParty;
use App\Models\Plaintiff;
use App\Models\PlaintiffRepresentative;
use App\Models\Defendant;
use App\Models\DefendantRepresentative;
use App\Models\Submitter;
use App\Models\TypeLawsuit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;

class LawsuitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawsuits = Lawsuit::all()->map(function ($lawsuit) {
            return new LawsuitResource($lawsuit);
        })->toJson();

        return view('content.lawsuits.index', ['lawsuits' => $lawsuits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $typeLawsuits = TypeLawsuit::all();
        return view('content.lawsuits.create', [ 'typeLawsuits' => $typeLawsuits]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $submitters = Submitter::all();
        $lawsuit = new Lawsuit();
        $lawsuit->type_lawsuit_id = $request['type_lawsuit_id'];
        $lawsuit->number = $request['number'];
        $lawsuit->name = $request['name'];
        $lawsuit->courts_departments = $request['courts'];
        $lawsuit->updated_at = now();
        $lawsuit->created_at = now();
        $lawsuit->save();
        if ($request['plaintiffs'][0]['value'] !== null) {
            foreach ($request->get('plaintiffs') as $plaintiff) {
                $createPlaintiff = new Plaintiff();
                $createPlaintiff->name = $plaintiff['value'];
                $createPlaintiff->submitter_id = $submitters[0]->id;
                $createPlaintiff->lawsuit_id = $lawsuit->id;
                $createPlaintiff->save();
            }
        }
        if ($request['plaintiff_representatives'][0]['value'] !== null) {
            foreach ($request->get('plaintiff_representatives') as $plaintiffRe) {
                $createPlaintiffRe = new PlaintiffRepresentative();
                $createPlaintiffRe->name = $plaintiffRe['value'];
                $createPlaintiffRe->submitter_id = $submitters[1]->id;
                $createPlaintiffRe->lawsuit_id = $lawsuit->id;
                $createPlaintiffRe->save();
            }
        }
        if ($request['defendants'][0]['value'] !== null) {
            foreach ($request->get('defendants') as $defendant) {
                $createDefendant = new Defendant();
                $createDefendant->name = $defendant['value'];
                $createDefendant->submitter_id = $submitters[1]->id;
                $createDefendant->lawsuit_id = $lawsuit->id;
                $createDefendant->save();
            }
        }
        if ($request['defendant_representatives'][0]['value'] !== null) {
            foreach ($request->get('defendant_representatives') as $defendantRe) {
                $createDefendantRe = new DefendantRepresentative();
                $createDefendantRe->name = $defendantRe['value'];
                $createDefendantRe->submitter_id = $submitters[1]->id;
                $createDefendantRe->lawsuit_id = $lawsuit->id;
                $createDefendantRe->save();
            }
        }
        if ($request['other_parties'][0]['value'] !== null) {
            foreach ($request->get('other_parties') as $otherParty) {
                $createOtherParty = new OtherParty();
                $createOtherParty->name = $otherParty['value'];
                $createOtherParty->submitter_id = $submitters[3]->id;
                $createOtherParty->lawsuit_id = $lawsuit->id;
                $createOtherParty->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Lawsuit $lawsuit
     * @return void
     */
    public function show(Lawsuit $lawsuit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lawsuit $lawsuit
     * @return void
     */
    public function edit(Lawsuit $lawsuit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Lawsuit $lawsuit
     * @return void
     */
    public function update(Request $request, Lawsuit $lawsuit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lawsuit $lawsuit
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Lawsuit $lawsuit)
    {
        $lawsuit->delete();
        $message = ['status'=>'success', 'message'=> 'Lawsuit delete successfully!'];
        return response()->json(['url'=> route('lawsuits.index'), 'message' => $message], 200);
    }
}
