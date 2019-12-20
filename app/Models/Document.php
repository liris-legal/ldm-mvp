<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $fillable = ['case_id', 'name', 'author'];
    public $timestamps = true;

    public function case()
    {
        return $this->belongsTo('App\Models\Cases');
    }

    public function categoryDocument()
    {
        return $this->belongsTo('App\Models\CategoryDocument');
    }
}
