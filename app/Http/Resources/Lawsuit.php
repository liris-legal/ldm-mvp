<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Defendant as DefendantResource;
use App\Http\Resources\Document as DocumentResource;
use App\Http\Resources\DefendantRepresentative as DefendantRepresentativeResource;
use App\Http\Resources\Plaintiff as PlaintiffResource;
use App\Http\Resources\PlaintiffRepresentative as PlaintiffRepresentativeResource;
use App\Http\Resources\OtherParty as OtherPartyResource;

class Lawsuit extends JsonResource
{
    public $collects = 'App\Http\Resource\Defendant';

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $format = '%EC%Ey年（ワ）';

        return [
            'id'                        => $this->id,
            'user_id'                   => $this->user_id,
            'type_lawsuit_id'           => $this->type_lawsuit_id,
            'number'                    => $this->number,
            'name'                      => $this->name,
            'courts_departments'        => $this->courts_departments,
            'defendants'                => $this->defendants->map(
                function ($defendant) {
                    return new DefendantResource($defendant);
                }
            ),
            'defendant_representatives' => $this->defendantRepresentatives->map(
                function ($defendant) {
                    return new DefendantRepresentativeResource($defendant);
                }
            ),
            'plaintiffs'                => $this->plaintiffs->map(
                function ($defendant) {
                    return new PlaintiffResource($defendant);
                }
            ),
            'plaintiff_representatives' => $this->plaintiffRepresentatives->map(
                function ($defendant) {
                    return new PlaintiffRepresentativeResource($defendant);
                }
            ),
            'other_parties' => $this->otherParties->map(
                function ($party) {
                    return new OtherPartyResource($party);
                }
            ),
            'documents' => $this->documents->map(function ($document) {
                return new DocumentResource($document);
            }),
            'created_at'                       => $this->created_at->isoFormat('LL'),
            'updated_at'                       => $this->updated_at ? $this->updated_at->isoFormat('LL') : null,
            'created_at_wareki'                => $this->created_at->formatLocalized($format),
        ];
    }
}
