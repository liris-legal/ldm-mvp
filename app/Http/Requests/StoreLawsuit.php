<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLawsuit extends FormRequest
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
            'type_lawsuit_id' => 'bail|required',
            'number' => 'bail|required|unique:lawsuits',
            'name' => 'bail|required|min:1|max:150',
            'courts_departments' => 'bail|required|min:1|max:150',

            'plaintiffs' => 'bail|array|max:20',
            'plaintiffs.*' => 'bail|required|string|distinct|min:1|max:150',

            'plaintiff_representatives' => 'bail|array|max:20',
            'plaintiff_representatives.*' => 'bail|nullable|string|distinct|min:1|max:150',

            'defendants' => 'bail|array|max:20',
            'defendants.*' => 'bail|required|string|distinct|min:1|max:150',

            'defendant_representatives' => 'bail|array|max:20',
            'defendant_representatives.*' => 'bail|nullable|string|distinct|min:1|max:150',

            'other_parties' => 'bail|array|max:20',
            'other_parties.*' => 'bail|nullable|string|distinct|min:1|max:150',
        ];

        if (isset($this->lawsuit)) {
            $rules['number'] = 'bail|required|unique:lawsuits,number,' . $this->lawsuit->id;
        }

        return $rules;
    }
}
