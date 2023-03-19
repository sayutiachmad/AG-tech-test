<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    
});

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('employee', [EmployeeApiController::class, 'store']);
    Route::post('employee/list', [EmployeeApiController::class, 'list']);
    Route::get('employee/{id}', [EmployeeApiController::class, 'show']);
    Route::put('employee/{id}', [EmployeeApiController::class, 'update']);
    Route::delete('employee/{id}', [EmployeeApiController::class, 'delete']);
});
