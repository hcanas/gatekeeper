<?php

namespace App\Http\Requests\Rules;

trait HasUserRules
{
    private $user_rules = [
        'given_name' => ['required'],
        'middle_name' => ['nullable'],
        'last_name' => ['required'],
        'name_suffix' => ['nullable'],
        'username' => ['required'],
        'password' => [],
        'confirm_password' => ['same:password'],
    ];

    private function getUserRules($fields = [])
    {
        if (empty($fields)) {
            return $this->user_rules;
        } else {
            return array_intersect_key($this->user_rules, array_flip($fields));
        }
    }
}