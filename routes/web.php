<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\CompanyController;
use App\Providers\RouteServiceProvider;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(RouteServiceProvider::LOGIN);
});

Route::get('/dashboard', [RegisteredUserController::class, 'ShowUsersFromSameCompany'])
    ->middleware(['auth', 'role:1,2'])->name('dashboard');

Route::get('/form', [FormController::class, 'show'])
    ->middleware('auth')->name('form');

Route::get('/results', [FormController::class, 'getResults'])
    ->middleware(['auth', 'role:1,2'])->name('results');

Route::get('/company', [CompanyController::class, 'create'])
    ->middleware(['auth', 'role:1'])
    ->name('company');

Route::post('/company', [CompanyController::class, 'store'])
    ->middleware('auth');

Route::get('/companies', [CompanyController::class, 'ShowCompanylist'])
    ->middleware(['auth', 'role:1'])
    ->name('companies');

Route::get('/users', [RegisteredUserController::class, 'ShowUserlist'])
    ->middleware(['auth', 'role:1'])
    ->name('users');

Route::get('/edit/{id}', [RegisteredUserController::class, 'edit'])
    ->middleware(['auth', 'role:1,2'])
    ->name('edit');

Route::put('/edit/{id}', [RegisteredUserController::class, 'update'])
    ->middleware(['auth', 'role:1,2'])
    ->name('update');

Route::post('/form', [FormController::class, 'store'])
    ->middleware(['auth'])
    ->name('form');

require __DIR__ . '/auth.php';
