<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Document extends Model
{
    protected $fillable = ['url', 'name', 'number', 'lawsuit_id', 'submitter_id', 'type_document_id', 'created_at'];

    public function submitter()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }

    public function typeDocument()
    {
        return $this->belongsTo('App\Models\TypeDocument');
    }

    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit');
    }
}
