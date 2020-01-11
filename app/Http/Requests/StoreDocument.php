<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submitter;
use App\Models\TypeDocument;

class StoreDocument extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $submitter = Submitter::findOrFail($this->submitter_id);
        $typeDocument = TypeDocument::findOrFail($this->type_document_id);
        return ($submitter->description == 'plaintiff' || $submitter->description == 'defendant')
        && ($typeDocument->description == 'evidence') ? [
            'number' => 'bail|required|numeric',
            'name' => 'bail|required|max:150',
            'file' => 'bail|required|mimes:pdf,doc,docx|max:204800',
            'type_document_id' => 'bail|required',
            'submitter_id' => 'bail|required',
            'lawsuit_id' => 'bail|required',
            'created_at' => 'bail|required',
        ] : [
            'name' => 'bail|required|max:150',
            'file' => 'bail|required|mimes:pdf,doc,docx|max:204800',
            'type_document_id' => 'bail|required',
            'submitter_id' => 'bail|required',
            'lawsuit_id' => 'bail|required',
            'created_at' => 'bail|required',
        ];
    }
}
