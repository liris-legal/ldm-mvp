<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'number',
        'subnumber',
        'name',
        'url',
        'documentable_id',
        'documentable_type',
        'lawsuit_id',
        'submitter_id',
        'type_document_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get all of the owning documentable models.
     */
    public function documentable()
    {
        return $this->morphTo();
    }

    /**
     * Get submitter for the Document.
     */
    public function submitter()
    {
        return $this->belongsTo('App\Models\Submitter', 'submitter_id');
    }

    /**
     * Get typeDocument for the Document.
     */
    public function typeDocument()
    {
        return $this->belongsTo('App\Models\TypeDocument');
    }

    /**
     * Get lawsuit for the Document.
     */
    public function lawsuit()
    {
        return $this->belongsTo('App\Models\Lawsuit');
    }
}
