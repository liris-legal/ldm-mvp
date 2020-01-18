<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherParty extends Model
{
    public $fillable = ['name', 'lawsuit_id'];

    /**
     * Get lawsuit for the OtherParty.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'lawsuit_id');
    }
}
