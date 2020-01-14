<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plaintiff extends Model
{
    public $fillable = ['name', 'lawsuit_id'];

    /**
     * Get lawsuit for the Plaintiff.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'lawsuit_id');
    }

    /**
     * Get documents for plaintiff.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
