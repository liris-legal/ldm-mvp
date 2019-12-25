<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeCase extends Model
{
    public $fillable = ['name'];
    public $timestamps = true;

    /**
     * Get all lawsuit for type lawsuit.
     */
    public function lawsuits()
    {
        return $this->hasMany('App\Models\Lawsuit');
    }
}
