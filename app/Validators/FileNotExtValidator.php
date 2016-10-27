<?php

namespace App\Validators;

class FileNotExtValidator extends \Illuminate\Validation\Validator
{
    protected function validateNotExt($attribute, $file, $allowExtension)
    {
        return !in_array($file->getClientOriginalExtension(), $allowExtension);
    }

    protected function replaceNotExt($message, $attribute, $rule, $parameters)
    {
        return str_replace(':values', implode(', ', $parameters), $message);
    }
}