<?php

namespace App\Exceptions\Http;

use App\Exceptions\AppException;
use App\Exceptions\FailurableResponse;
use App\Responses\FailureResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use function is_int;

/**
 * Class HttpExcepion
 * @package App\Exceptions\Http
 */
class HttpException extends AppException implements FailurableResponse
{
    /**
     * UnexpectedException constructor.
     * @param Exception $t
     */
    public function __construct(Throwable $t)
    {
        parent::__construct(
            $t->getMessage(),
            is_int($t->getCode()) ? $t->getCode() : 0,
            $t
        );
    }

    /**
     * @param Throwable $t
     * @return HttpException
     */
    public static function convertToHttpException(Throwable $t): HttpException
    {
        if ($t instanceof NotFoundHttpException || $t instanceof ModelNotFoundException) {
            $exception = new NotFoundException($t);

        } elseif ($t instanceof MethodNotAllowedHttpException) {
            $exception = new MethodNotAllowed($t);

        } elseif ($t instanceof UnauthorizedHttpException) {
            $exception = new TokenNotProvidedException($t);

        } elseif ($t instanceof AuthorizationException) {
            $exception = new UnauthorizedAccessException($t);

        } else {
            $exception = new UnexpectedException($t);
        }

        return $exception;
    }

    /**
     * @return FailureResponse
     */
    public function createFailureResponse(): FailureResponse
    {
        return new FailureResponse($this);
    }
}
