<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defendant extends Model
{
    public $fillable = ['name'];

    public function case()
    {
        return $this->belongsTo('App\Models\Cases');
    }
}
