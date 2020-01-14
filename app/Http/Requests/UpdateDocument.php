<?php

namespace App\Http\Requests;

use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submitter;
use App\Models\TypeDocument;
use App\Models\Lawsuit;

class UpdateDocument extends FormRequest
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

        $rules = [
            'name'              => 'bail|required|max:150',
            'number'            => 'bail|max:100|min:1|nullable',
            'file'              => 'bail|required|mimes:pdf,doc,docx|max:204800',
            'type_document_id'  => 'bail|required|exists:type_documents,id',
            'submitter_id'      => 'bail|required|exists:submitters,id',
            'lawsuit_id'        => 'bail|required|exists:lawsuits,id',
            'created_at'        => 'bail|required|date_format:Y-m-d|before:tomorrow',
        ];

        // create request
        if ($this->method('POST')) {
            if (($this->submitter_id == '1' || $this->submitter_id == '3') && $this->type_document_id == 2) {
                $rules['number'] = 'bail|required|numeric|max:100|min:1|unique:documents,number,NULL,id,lawsuit_id,' . $this->lawsuit_id
                . ',submitter_id,' . $this->submitter_id . ',name,' . $this->name;
            }
        }
        // update request
        if ($this->method('PATCH')) {
            if (isset($this->document)) {
                $rules['file'] = 'bail|mimes:pdf,doc,docx|max:204800';

                if (isset($this->document) && ($this->document->submitter_id == 1 || $this->document->submitter_id == 3)
                    && ($this->document->type_document_id == 2)) {
                    $rules['number'] = 'bail|required|numeric|unique:documents,number,'
                        . $this->document->id . ',id,lawsuit_id,' . $this->document->lawsuit_id
                        . ',submitter_id,' . $this->document->submitter_id . ',name,' . $this->document->name;
                    $rules['file'] = 'bail|mimes:pdf,doc,docx';
                }
            }
        }

        return $rules;
    }
}
