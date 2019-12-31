<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Defendant as DefendantResource;
use App\Http\Resources\DefendantRepresentative as DefendantRepresentativeResource;
use App\Http\Resources\Plaintiff as PlaintiffResource;
use App\Http\Resources\PlaintiffRepresentative as PlaintiffRepresentativeResource;

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
            'id' => $this->id,
            'type_case_id' => $this->type_case_id,
            'number' => $this->number,
            'name' => $this->name,
            'courts_departments' => $this->courts_departments,
            'defendants'    => DefendantResource::collection($this->defendants),
            'defendant_representatives' => DefendantRepresentativeResource::collection($this->defendantRepresentatives),
            'plaintiffs' => PlaintiffResource::collection($this->plaintiffs),
            'plaintiff_representatives' => PlaintiffRepresentativeResource::collection($this->plaintiffRepresentatives),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
