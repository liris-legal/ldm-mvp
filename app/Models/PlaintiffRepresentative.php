<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaintiffRepresentative extends Model
{
    public $fillable = ['name', 'lawsuit_id'];

    /**
     * Get lawsuit for the Plaintiff Representative.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'lawsuit_id');
    }
}
