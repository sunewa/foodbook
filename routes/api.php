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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:web']], function () {
    Route::apiResource('user', 'API\UserController');

    Route::post('image-upload','API\PostController@imageUpload');
    
    Route::get('/posts/categories','API\PostController@getCategorys');
    Route::get('/posts/tags','API\PostController@getTags');
    Route::post('posts/check-slug','API\PostController@checkSlug');
    Route::apiResource('posts', 'API\PostController');
    
    

    Route::get('profile','API\UserController@profile');
});