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

Route::get('/', 'App\Http\Controllers\TopController@main')->name('top.main');
Route::get('about', 'App\Http\Controllers\TopController@about')->name('top.about');

Route::get('user/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');
Route::get('user/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('user.edit');
Route::post('user/update/', 'App\Http\Controllers\UserController@update')->name('user.update');;

Route::get('recipe/index', 'App\Http\Controllers\RecipeController@index')->name('recipe.index');
Route::get('recipe/{id}', 'App\Http\Controllers\RecipeController@show')->name('recipe.show');
Route::get('recipe/edit/{id}', 'App\Http\Controllers\RecipeController@edit')->name('recipe.edit');

Route::get('ingredient/edit/{id}', 'App\Http\Controllers\IngredientController@edit')->name('ingredient.edit');

Route::get('cooking/edit/{id}', 'App\Http\Controllers\CookingController@edit')->name('cooking.edit');