<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasUserRules;

class CreateUser extends BaseFormRequest
{
    use HasUserRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->getUserRules();
        $rules['username'][] = 'unique:users';
        $rules['password'][] = 'required';

        return $this->getUserRules();
    }
}
