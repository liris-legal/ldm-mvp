<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submitter;
use App\Models\TypeDocument;
use App\Models\Document;
use Illuminate\Support\Facades\Validator;

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
        $rules = [
            'name'              => 'bail|required|max:150',
            'number'            => 'bail|max:100|min:1|nullable',
            'subnumber'         => 'bail|max:50|min:1|nullable',
            'file'              => 'bail|required|file|mimes:pdf|max:204800',
            'type_document_id'  => 'bail|required|exists:type_documents,id',
            'submitter_id'      => 'bail|required',
            'lawsuit_id'        => 'bail|required|exists:lawsuits,id',
            'created_at'        => 'bail|required|date_format:Y-m-d|before:tomorrow',
        ];

        if (($this->submitter_id == 1 || $this->submitter_id == 3) && $this->type_document_id == 2) {
            $rules['number'] = 'bail|required|numeric|max:100|min:1|unique:documents,number,NULL,id'
                . ',lawsuit_id,' . $this->lawsuit_id . ',submitter_id,' . $this->submitter_id . ',name,' . $this->name
                . ',subnumber,' . ($this->subnumber + 1);

            // validate exists subnumber
            $this->validatedExists();
        }

        return $rules;
    }

    /**
     * Validated request filed.
     *
     */
    public function validatedExists()
    {
        if ($this->subnumber > 0 && ($this->name === '乙号証' || $this->name === '甲号証')) {
            $input = $this->only('subnumber');
            $rules = ['subnumber' => 'bail|required|numeric|max:50|min:1|exists:documents,subnumber'
                . ',lawsuit_id,' . $this->lawsuit_id . ',submitter_id,' . $this->submitter_id
                . ',name,' . $this->name . ',number,' . $this->number
            ];

            // $messages = ['exists' => 'subnumberには、存在ではありません。'];
            // message:
            // 乙第1号証の2 when 乙第1号証 is not exist , then occur error not exist 乙第1号証.
            // @see https://gitlab.com/ConnectivCorporation/contract/liris/LDM/issues/10#note_281202966
            // $party = strpos($this->name, '乙') ? '乙' : '甲';
            // $subnumber = $party . '第' . $this->subnumber . '号証';
            // $messages['exists'] = str_replace('subnumber', $subnumber, $messages['exists']);

            $messages = ['exists' => ':attributeに抜け番があります。'];

            Validator::make($input, $rules, $messages)->validate();
        }
    }
}
