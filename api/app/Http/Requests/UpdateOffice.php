<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasOfficeRules;

class UpdateOffice extends BaseFormRequest
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
        $rules['name'][] = 'unique:offices,name,'.$this->route('office');
        $rules['short_name'][] = 'unique:offices,short_name,'.$this->route('office');

        return $rules;
    }
}
