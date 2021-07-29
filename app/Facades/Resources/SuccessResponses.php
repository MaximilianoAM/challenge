<?php

namespace App\Facades\Resources;

use Illuminate\Support\Facades\Facade;

/**
 * Class SuccessResponses
 * @package App\Facades\Resources
 */
class SuccessResponses extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'success-responses';
    }
}
