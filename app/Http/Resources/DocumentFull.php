<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Services\FileService;

class DocumentFull extends JsonResource
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
            'id'                       =>  $this->id,
            'number'                   =>  $this->number,
            'name'                     =>  $this->name,
            'url'                      =>  (new FileService())->getFileUrlS3($this->url),
            'lawsuit_id'               =>  $this->lawsuit_id,
            'type'                     =>  $this->typeDocument,
            'submitter'                =>  $this->submitter,
            'created_at'               =>  $this->created_at,
            'created_at_wareki'        =>  Carbon::parse($this->created_at)->isoFormat('YYYY年MM月DD日'),
            'updated_at'               =>  $this->updated_at ? $this->updated_at->isoFormat('LL') : null,
        ];
    }
}
