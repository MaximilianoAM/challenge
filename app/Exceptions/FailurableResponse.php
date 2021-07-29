<?php

namespace App\Exceptions;

use App\Responses\FailureResponse;

/**
 * Interface FailurableResponse
 * @package App\Interfaces
 */
interface FailurableResponse
{
    /**
     * @return FailureResponse
     */
    public function createFailureResponse(): FailureResponse;
}
