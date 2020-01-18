<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defendant extends Model
{
    public $fillable = ['name', 'lawsuit_id', 'submitter_id'];

    /**
     * Get lawsuit for the Defendant.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\lawsuits', 'lawsuit_id');
    }

    /**
     * Get document for the Defendant.
     */
//    public function documents()
//    {
//        return $this->hasMany('App\Models\Document', 'document_id');
//    }

    /**
     * Get the plaintiff's documents.
     */
    public function documents()
    {
        return $this->morphMany('App\Models\Document', 'documentable');
    }

    /**
     * Get submitter for the Defendant.
     */
    public function submitter()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }

}
