<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeCase extends Model
{
    public $fillable = ['name'];
    public $timestamps = true;

    /**
     * Get all cases for type case.
     */
    public function cases()
    {
        return $this->hasMany('App\Models\Cases');
    }
}
