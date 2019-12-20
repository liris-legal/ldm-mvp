<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    public $fillable = ['category_id', 'number', 'name', 'other_parties'];
    public $timestamps = true;

    public function categoryCase()
    {
        return $this->belongsTo('App\Models\CategoryCase');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    public function defendants()
    {
        return $this->hasMany('App\Models\Defendant');
    }

    public function defendantsAgent()
    {
        return $this->hasMany('App\Models\DefendantAgent');
    }

    public function plaintiff()
    {
        return $this->hasMany('App\Models\Plaintiff');
    }

    public function plaintiffAgent()
    {
        return $this->hasMany('App\Models\PlaintiffAgent');
    }
}
