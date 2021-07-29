<?php

namespace App\Exceptions\Http;

use App\Exceptions\AppException;
use App\Exceptions\FailurableResponse;
use App\Responses\FailureResponse;
use Illuminate\Validation\Validator;

/**
 * Class FormValidationException
 * @package App\Exceptions\Http
 */
class ValidationException extends AppException implements FailurableResponse
{
    /**
     * @var Validator
     */
    private $validator;


    /**
     * ValidationException constructor.
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        parent::__construct();

        $this->validator = $validator;
    }

    /**
     * @return FailureResponse
     */
    public function createFailureResponse(): FailureResponse
    {
        return new FailureResponse($this, $this->errors());
    }

    /**
     * @return array
     */
    private function errors(): array
    {
        $errors = collect();

        $messages = collect(
            $this->validator
                ->messages()
                ->toArray()
        );

        $messages->each(function ($message, $field) use ($errors) {
            $errors[] = [
                'field' => $field,
                'message' => current($message)
            ];
        });

        return $errors->all();
    }
}
