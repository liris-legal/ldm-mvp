<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submitter extends Model
{
    public $fillable = ['name'];

    /**
     * Get all plaintiffs for submitter.
     */
    public function plaintiffs()
    {
        return $this->hasMany('App\Models\Plaintiff');
    }

    /**
     * Get all plaintiffs for submitter.
     */
    public function defendants()
    {
        return $this->hasMany('App\Models\Defendant');
    }

    /**
     * Get all documents for submitter.
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
