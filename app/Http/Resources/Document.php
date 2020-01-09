<?php

namespace App\Http\Resources;

use App\Http\Controllers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Document extends JsonResource
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
            'id'                       =>  $this->id,
            'number'                   =>  $this->number,
            'name'                     =>  $this->name,
            'url'                      =>  $this->url,
            'type_document_id'         =>  $this->type_document_id,
            'submitter_id'             =>  $this->submitter_id,
            'created_at'               =>  $this->created_at,
            'created_at_wareki'        =>  $this->created_at->isoFormat('YYYY年MM月DD日'),
            'updated_at'               =>  $this->updated_at ? $this->updated_at->isoFormat('LL') : null,
        ];
    }
}
