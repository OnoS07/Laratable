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

Route::get('user', 'App\Http\Controllers\UserController@show')->name('user.show');
Route::get('user/edit', 'App\Http\Controllers\UserController@edit')->name('user.edit');
Route::post('user/update/', 'App\Http\Controllers\UserController@update')->name('user.update');;

Route::get('recipe/index', 'App\Http\Controllers\RecipeController@index')->name('recipe.index');
Route::get('recipe', 'App\Http\Controllers\RecipeController@show')->name('recipe.show');
Route::get('recipe/edit', 'App\Http\Controllers\RecipeController@edit')->name('recipe.edit');
Route::post('recipe/update', 'App\Http\Controllers\RecipeController@update')->name('recipe.update');
Route::get('recipe/create', 'App\Http\Controllers\RecipeController@create')->name('recipe.create');
Route::post('recipe/store', 'App\Http\Controllers\RecipeController@store')->name('recipe.store');
Route::post('recipe/destroy', 'App\Http\Controllers\RecipeController@destroy')->name('recipe.destroy');

Route::get('recipe/{id}/ingredients/edit', 'App\Http\Controllers\IngredientController@edit')->name('ingredient.edit');

Route::get('cooking/edit', 'App\Http\Controllers\CookingController@edit')->name('cooking.edit');