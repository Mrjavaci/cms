<?php

namespace VirtaraCase\Validation;

use VirtaraCase\Request\Request;
use VirtaraCase\Traits\UseMakeTrait;

class Validation
{
    use UseMakeTrait;

    public function validate(array $rules)
    {
        foreach ($rules as $key => $rule) {
            $value = Request::make()->getParameters()[$key] ?? null;
            $rules = explode('|', $rule);

            foreach ($rules as $ruleSub) {
                if ($ruleSub === 'required' && empty($value)) {
                    throw new \Exception("Field $key is required");
                }

                if ($ruleSub === 'email' && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Field $key must be a valid email");
                }
                if ($ruleSub === 'numeric' && ! is_numeric($value)) {
                    throw new \Exception("Field $key must be a number");
                }
            }
        }
    }
}