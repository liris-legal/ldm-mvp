<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\Document as DocumentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Defendant extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                =>  $this->id,
            'name'              =>  $this->name,
            'submitter'         =>  $this->submitter
        ];
    }
}
