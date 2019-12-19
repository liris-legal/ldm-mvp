<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryCase extends Model
{
    public $fillable = ['name'];
    public $timestamps = true;

    public function cases()
    {
        return $this->hasMany('App\Models\CategoryCase');
    }
}
