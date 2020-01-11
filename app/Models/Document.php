<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['url', 'name', 'number', 'submitter_id', 'type_document_id'];
    public $timestamps = true;

    public function submiter()
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
