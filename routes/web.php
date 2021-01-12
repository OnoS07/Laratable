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

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('login/guest', '\App\Http\Controllers\Auth\LoginController@guestLogin');

Route::get('/', 'App\Http\Controllers\TopController@home');
Route::get('about', 'App\Http\Controllers\TopController@about');

Route::get('user/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');
Route::get('user/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('user.edit');
Route::post('user/update/', 'App\Http\Controllers\UserController@update')->name('user.update');;