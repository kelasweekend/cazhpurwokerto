<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();


Route::prefix('v1')->middleware('auth')->group(function () {
    Route::get('company', [App\Http\Controllers\Api\CompanyController::class, 'index']);
    Route::resource('employee', '\App\Http\Controllers\EmployeeController');
    Route::post('employee/ajax', [App\Http\Controllers\EmployeeController::class, 'getcompany'])->name('getcompany');
    Route::get('history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history');

    // add balance
    Route::get('company/balance/{id}', [App\Http\Controllers\CompanyController::class, 'getbalance'])->name('getbalance');
    Route::post('company/balance/{id}', [App\Http\Controllers\CompanyController::class, 'addbalance'])->name('addbalance');
});
