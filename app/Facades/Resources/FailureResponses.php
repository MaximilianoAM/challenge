<?php

namespace App\Facades\Resources;

use Illuminate\Support\Facades\Facade;

/**
 * Class FailureResponses
 * @package App\Facades\Resources
 */
class FailureResponses extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'failure-responses';
    }
}
