<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource(
    'users',
    UserController::class
);

Route::resource(
    'accounts',
    AccountController::class
);

Route::post(
    'accounts/{account}/make-transaction',
    [AccountController::class, 'makeTransaction']
);
