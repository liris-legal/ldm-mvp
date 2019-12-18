<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    public $fillable = ['category_id', 'number', 'name', 'other_parties'];
    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
