<?php

namespace App\Http\Requests;

use App\Http\Requests\Rules\HasPermissionRules;

class UpdatePermission extends BaseFormRequest
{
    use HasPermissionRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->getPermissionRules();
        $rules['name'][] = 'unique:permissions,name,'.$this->route('permission');

        return $rules;
    }
}
