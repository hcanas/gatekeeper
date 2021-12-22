<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasOfficeRules;

class CreateOffice extends BaseFormRequest
{
    use HasOfficeRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->getOfficeRules();
        $rules['name'][] = 'unique:offices';
        $rules['short_name'][] = 'unique:offices';

        return $rules;
    }
}
