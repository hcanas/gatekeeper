<?php

namespace App\Http\Requests\Rules;

trait HasPermissionRules
{
    private $permission_rules = [
        'name' => ['required'],
    ];

    private function getPermissionRules($fields = [])
    {
        if (empty($fields)) {
            return $this->permission_rules;
        } else {
            return array_intersect_key($this->permission_rules, array_flip($fields));
        }
    }
}