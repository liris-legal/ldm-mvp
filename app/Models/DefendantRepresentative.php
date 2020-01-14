<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefendantRepresentative extends Model
{
    public $fillable = ['name', 'lawsuit_id'];

    /**
     * Get lawsuit for the Defendant Representative.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\lawsuit', 'lawsuit_id');
    }
}
