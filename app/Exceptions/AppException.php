<?php

namespace App\Exceptions;

/**
 * Class AppException
 * @package App\Exceptions
 */
abstract class AppException extends \Exception
{
    /**
     * @return string
     */
    public function getResponseCode() : string
    {
        return get_class($this);
    }
}
