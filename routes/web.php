<?php

use App\Http\Controllers\Auth\SetAuthCookieController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/set-cookie', [SetAuthCookieController::class, 'set'])->name('app.set.cookie');

// Routes for Fortify Authentication
Auth::routes();

Route::group(['middleware' => ['auth.token.cookies',]], function () {
    Route::get('/', [HomeController::class, 'index'])->name('app.index');
    Route::get('/home', [HomeController::class, 'index'])->name('app.home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('app.dashboard');
    Route::get('/employee', [EmployeeController::class, 'index'])->name('app.employee');
    Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('app.employee.show');
});