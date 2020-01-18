<?php

namespace App\Http\Resources;

use App\Http\Controllers\Helpers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\FileService;

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
            'lawsuit_id'               =>  $this->lawsuit_id,
            'type'                     =>  $this->typeDocument,
            'submitter'                =>  $this->submitter,
            'documentable'             =>  $this->documentable,
            'created_at'               =>  $this->created_at,
            'created_at_wareki'        =>  $this->created_at->isoFormat('YYYY年MM月DD日'),
            'updated_at'               =>  $this->updated_at ? $this->updated_at->isoFormat('LL') : null,
        ];
    }
}
