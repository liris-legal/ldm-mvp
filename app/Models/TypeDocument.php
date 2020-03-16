<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    public $fillable = ['name'];
    public $timestamps = true;

    public function documents()
    {
        return $this->hasMany('App\Models\TypeDocument');
    }
}
