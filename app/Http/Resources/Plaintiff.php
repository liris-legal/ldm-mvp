<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Document as DocumentResource;

class Plaintiff extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                =>  $this->id,
            'name'              =>  $this->name,
            'type_author_id'    =>  $this->submitter_id,
            'documents'         =>  $this->submitter->documents->map(
                function ($document) {
                    return new DocumentResource($document);
                }
            )
        ];
    }
}
