<?php

use App\Exceptions\Http\MethodNotAllowed;
use App\Exceptions\Http\NotFoundException;
use App\Exceptions\Http\TokenNotProvidedException;
use App\Exceptions\Http\UnauthorizedAccessException;
use App\Exceptions\Http\UnexpectedException;
use App\Exceptions\Http\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

return [
    TokenNotProvidedException::class => [
        'message' => Lang::get('failure.' . TokenNotProvidedException::class),
        'code' => 'api.error.tokenNotProvided',
        'statusCode' => Response::HTTP_UNAUTHORIZED
    ],

    UnauthorizedAccessException::class => [
        'message' => Lang::get('failure.' . UnauthorizedAccessException::class),
        'code' => 'api.error.unauthorizedAccess',
        'statusCode' => Response::HTTP_UNAUTHORIZED
    ],

    MethodNotAllowed::class => [
        'message' => Lang::get('failure.' . MethodNotAllowed::class),
        'code' => 'api.error.methodNotAllowed',
        'statusCode' => Response::HTTP_METHOD_NOT_ALLOWED
    ],

    NotFoundException::class => [
        'message' => Lang::get('failure.' . NotFoundException::class),
        'code' => 'api.error.notFound',
        'statusCode' => Response::HTTP_NOT_FOUND
    ],

    UnexpectedException::class => [
        'message' => Lang::get('failure.' . UnexpectedException::class),
        'code' => 'api.error.unexpected',
        'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR
    ],

    ValidationException::class => [
        'message' => Lang::get('failure.' . ValidationException::class),
        'code' => 'api.error.validation',
        'statusCode' => Response::HTTP_BAD_REQUEST
    ],
];
