<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Defendant as DefendantResource;

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
