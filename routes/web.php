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
Route::post('ingredient/update', 'App\Http\Controllers\IngredientController@update')->name('ingredient.update');
Route::post('ingredient/store', 'App\Http\Controllers\IngredientController@store')->name('ingredient.store');
Route::post('ingredient/destroy', 'App\Http\Controllers\IngredientController@destroy')->name('ingredient.destroy');

Route::get('recipe/{id}/cookings/edit', 'App\Http\Controllers\CookingController@edit')->name('cooking.edit');
Route::post('cooking/store', 'App\Http\Controllers\CookingController@store')->name('cooking.store');
Route::post('cooking/update', 'App\Http\Controllers\CookingController@update')->name('cooking.update');
Route::post('cooking/destroy', 'App\Http\Controllers\CookingController@destroy')->name('cooking.destroy');

Route::post('comment/store', 'App\Http\Controllers\CommentController@store')->name('comment.store');
Route::post('comment/destroy', 'App\Http\Controllers\CommentController@destroy')->name('comment.destroy');

Route::post('favorite/store', 'App\Http\Controllers\FavoriteController@store')->name('favorite.store');
Route::post('favorite/destroy', 'App\Http\Controllers\FavoriteController@destroy')->name('favorite.destroy');