<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $fillable = ['url', 'name', 'number', 'type_author_id', 'type_document_id'];
    public $timestamps = true;

    public function typeAuthor()
    {
        return $this->belongsTo('App\Models\TypeAuthor', 'type_author_id');
    }

    public function typeDocument()
    {
        return $this->belongsTo('App\Models\TypeDocument');
    }
}
