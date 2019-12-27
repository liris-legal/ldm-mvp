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
                $create_plaintiff = new Plaintiff();
                $create_plaintiff->name = $plaintiff['value'];
                $create_plaintiff->submitter_id = $submitters[0]->id;
                $create_plaintiff->lawsuit_id = $lawsuit->id;
                $create_plaintiff->save();
            }
        }

        if ($request['plaintiff_representatives'][0]['value'] !== null) {
            foreach ($request->get('plaintiff_representatives') as $plaintiff_r) {
                $create_plaintiff_r = new PlaintiffRepresentative();
                $create_plaintiff_r->name = $plaintiff_r['value'];
                $create_plaintiff_r->submitter_id = $submitters[1]->id;
                $create_plaintiff_r->lawsuit_id = $lawsuit->id;
                $create_plaintiff_r->save();
            }
        }

        if ($request['defendants'][0]['value'] !== null) {
            foreach ($request->get('defendants') as $defendant) {
                $create_defendant = new Defendant();
                $create_defendant->name = $defendant['value'];
                $create_defendant->submitter_id = $submitters[1]->id;
                $create_defendant->lawsuit_id = $lawsuit->id;
                $create_defendant->save();
            }
        }

        if ($request['defendant_representatives'][0]['value'] !== null) {
            foreach ($request->get('defendant_representatives') as $defendant_r) {
                $create_defendant_r = new DefendantRepresentative();
                $create_defendant_r->name = $defendant_r['value'];
                $create_defendant_r->submitter_id = $submitters[1]->id;
                $create_defendant_r->lawsuit_id = $lawsuit->id;
                $create_defendant_r->save();
            }
        }

        if ($request['other_parties'][0]['value'] !== null) {
            foreach ($request->get('other_parties') as $other_party) {
                $create_other_party = new OtherParty();
                $create_other_party->name = $other_party['value'];
                $create_other_party->submitter_id = $submitters[3]->id;
                $create_other_party->lawsuit_id = $lawsuit->id;
                $create_other_party->save();
            }
        }
        return redirect()->route('lawsuits.index')->with([
            'status' => 'success',
            'message' => 'Lawsuit created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function show(Cases $cases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function edit(Cases $cases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function update(Request $request, Cases $cases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cases  $cases
     * @return Response
     */
    public function destroy(Cases $cases)
    {
        //
    }
}
