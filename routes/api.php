<?php

use Illuminate\Http\Request;

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

Route::get('/products', 'ProductsController@index')->middleware('api');

Route::get('/users/{id}/children', 'UsersController@getChildren')->middleware('api');
Route::get('/children/{id}', 'ChildrenController@get')->middleware('api');
Route::post('/users/{id}/children', 'UsersController@addChild')->middleware('api');
Route::get('/children/{id}/destroy', 'ChildrenController@destroy')->middleware('api');
Route::post('/children/{id}', 'ChildrenController@update')->middleware('api');
Route::get('/children/{id}/allowed_products', 'ChildrenController@allowedProducts')->middleware('api');
Route::get('/children/{cid}/add_to_blacklist/{pid}', 'ChildrenController@addToBlacklist')->middleware('api');
Route::get('/children/{cid}/remove_from_blacklist/{pid}', 'ChildrenController@removeFromBlacklist')->middleware('api');
Route::get('/children/{cid}/buy/{pid}', 'ChildrenController@buy')->middleware('api');
Route::get('/children/{cid}/history', 'ChildrenController@history')->middleware('api');
Route::get('/children/{cid}/credit', 'ChildrenController@credit')->middleware('api');
Route::get('/children/{cid}/credit_used_this_month', 'ChildrenController@creditUsedThisMonth')->middleware('api');

Route::post('/users/{id}/cards', 'UsersController@addCard')->middleware('api');
Route::get('/users/{id}/cards', 'UsersController@getCards')->middleware('api');
Route::get('/cards/{id}', 'CardsController@get')->middleware('api');
Route::get('/cards/{id}/destroy', 'CardsController@destroy')->middleware('api');



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
