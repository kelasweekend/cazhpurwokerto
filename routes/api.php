<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('company', [App\Http\Controllers\Api\CompanyController::class, 'index']);
    Route::post('company/create', [App\Http\Controllers\Api\CompanyController::class, 'store']);
    Route::delete('company/delete/{id}', [App\Http\Controllers\Api\CompanyController::class, 'destroy']);

    Route::get('history', [App\Http\Controllers\Api\HistoryController::class, 'index']);


    Route::get('employee', [App\Http\Controllers\Api\EmployeeController::class, 'index']);
});
