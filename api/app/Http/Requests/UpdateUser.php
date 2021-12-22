<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasUserRules;

class UpdateUser extends BaseFormRequest
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
        $rules['id'] = ['exists:users'];
        $rules['username'][] = 'unique:users,username,'.$this->route('user')->id;
        $rules['password'][] = ['nullable'];
        $rules['confirm_password'][] = ['nullable'];

        return $rules;
    }
}
