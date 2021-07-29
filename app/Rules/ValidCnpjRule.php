<?php

namespace App\Rules;

use Bissolli\ValidadorCpfCnpj\CNPJ;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class ValidCnpjRule implements Rule
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
        $document = new CNPJ($value);
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
