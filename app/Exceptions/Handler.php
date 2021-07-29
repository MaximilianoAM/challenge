<?php

namespace App\Exceptions;

use App\Exceptions\Http\HttpException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var array
     */
    protected $internalDontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    /**
     * @param Throwable $t
     * @throws Exception
     */
    public function report(Throwable $t)
    {
        parent::report($t);
    }

    /**
     * @param Request $request
     * @param Throwable $throwable
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $throwable)
    {
        if (!$throwable instanceof FailurableResponse) {
            $throwable = HttpException::convertToHttpException($throwable);
        }

        return parent::render($request, $throwable);
    }

    /**
     * @param Request $request
     * @param Throwable $t
     * @return JsonResponse
     */
    protected function prepareResponse($request, Throwable $t): JsonResponse
    {
        return $this->convertExceptionToResponse($t);
    }

    /**
     * @param Throwable $t
     * @return JsonResponse
     */
    protected function convertExceptionToResponse(Throwable $t): JsonResponse
    {
        return $t
            ->createFailureResponse()
            ->toResponse(request());

    }

    /**
     * @param Request $request
     * @param Exception $t
     * @return JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $t): JsonResponse
    {
        return $this->convertExceptionToResponse($t);
    }
}
