<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Defendant as DefendantResource;
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
        return [
            'id'                        => $this->id,
            'type_lawsuit_id'              => $this->type_lawsuit_id,
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
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
