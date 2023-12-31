<?php

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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('payments', 'PaymentsController');
Route::get('profile', 'HomeController@profile')->name('profile');

//Route::get('/checkout', 'CheckoutController@getFunction')->name('checkout');
Route::get('/{any}', 'HomeController@index');