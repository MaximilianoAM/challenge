<?php

use App\Exceptions\Http\MethodNotAllowed;
use App\Exceptions\Http\NotFoundException;
use App\Exceptions\Http\TokenNotProvidedException;
use App\Exceptions\Http\UnauthorizedAccessException;
use App\Exceptions\Http\UnexpectedException;
use App\Exceptions\Http\ValidationException;

return [
    TokenNotProvidedException::class => 'Oops... authentication token was not provided',
    UnauthorizedAccessException::class => 'Oops... it looks like you don\'t have permission to access this feature',
    MethodNotAllowed::class => 'Oops... this method is not allowed for this feature',
    NotFoundException::class => 'Oops... the requested resource was not found',
    UnexpectedException::class => 'Oops... an unexpected error occurred',
    ValidationException::class => 'Data must conform to their respective requirements',
];
