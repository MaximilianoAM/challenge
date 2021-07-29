<?php

namespace App\Rules;

use Bissolli\ValidadorCpfCnpj\CPF;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class ValidCpfRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $document = new CPF($value);
        return $document->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('validation.custom.type.'.self::class);
    }
}
