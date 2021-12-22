<?php

namespace App\Http\Requests\Rules;

trait HasOfficeRules
{
    private $office_rules = [
        'name' => ['required'],
        'short_name' => ['required'],
        'office_id' => ['nullable', 'exists:offices,id'],
    ];

    private function getOfficeRules($fields = [])
    {
        if (empty($fields)) {
            return $this->office_rules;
        } else {
            return array_intersect_key($this->office_rules, array_flip($fields));
        }
    }
}