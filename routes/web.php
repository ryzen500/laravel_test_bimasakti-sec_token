<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/order-payment', 'PaymentController@index')->name('order-payment');
Route::post('/order-payment/simpan', 'PaymentController@simpan')->name('order-payment.simpan');
Route::get('/payment', 'PaymentController@indexPayment')->name('payments');
Route::post('/payment/simpan', 'PaymentController@simpanPembayaran')->name('payment.simpan');
Route::get('/status', 'PaymentController@indexStatus')->name('status');
Route::post('/status/simpan', 'PaymentController@submitStatus')->name('status.simpan');


Route::get('/about', function () {
    return view('about');
})->name('about');
