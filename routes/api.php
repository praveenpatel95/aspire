<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
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

Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('register-customer', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::group(['middleware'=> ['auth:api','role:admin'], 'prefix'=>'admin'], function(){
    Route::post('loan-approve', [LoanController::class, 'approve']);
    Route::post('loan-detail', [LoanController::class, 'detailByLoanNo']);
});

Route::group(['middleware'=> ['auth:api','role:customer']], function(){
    Route::post('loan-apply', [LoanController::class,'create']);
    Route::post('loan-status', [LoanController::class, 'statusByLoanNo']);
    Route::post('loan-pay', [LoanController::class,'loanPay']);
});
