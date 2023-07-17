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

Route::get('paymentOptions', 'PaymentOptionController@getPaymentOptions');


Route::middleware('auth:api')->get('/payments', 'API\PaymentsController@index');
Route::middleware('auth:api')->post('/payments', 'API\PaymentsController@store');
Route::middleware('auth:api')->get('/auth', 'API\AuthController@authUser');

Route::middleware('auth:api')->post('/profile', 'API\AuthController@updateProfile');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});