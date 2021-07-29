<?php

namespace App\Responses;

use App\Exceptions\AppException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

/**
 * Class FailureResponse
 * @package App\Responses
 */
class FailureResponse extends Response
{
    /**
     * @var FlattenException
     */
    private FlattenException $exception;

    /**
     * @var array
     */
    private array $errors;

    /**
     * Failure constructor.
     * @param AppException $e
     * @param array $errors
     */
    public function __construct(AppException $e, array $errors = [])
    {
        parent::__construct(Response::FAILURE, $e->getResponseCode());

        $this->exception = FlattenException::create(
            $e,
            $this->getStatusCode()
        );

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $this->schema['errors'] = $this->errors;

        if ($this->isDebugEnable) {
            $this->loadDebugInfo($this->exception);
        }

        return $this->schema;
    }

    /**
     * @param FlattenException $exception
     */
    private function loadDebugInfo(FlattenException $exception): void
    {
        $this->schema['debug'] = $exception->toArray();
    }
}
