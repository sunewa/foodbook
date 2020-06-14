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



Route::post('/home/feedback','API\HomeController@storeFeedback');

Route::get('/home/products','API\ProductController@home');
Route::get('/home/products/{slug}','API\ProductController@homeShow');
Route::get('/home/posts','API\PostController@home');
Route::get('/home/posts/{slug}','API\PostController@homeShow');

Route::post('/home/posts/comment/{slug}','API\CommentController@store');
Route::get('/home/posts/comment/{slug}','API\CommentController@getAll');
Route::delete('/home/posts/comment/{slug}/{id}','API\CommentController@destroy');

Route::post('/home/posts/like/{slug}','API\LikeController@store');
Route::get('/home/posts/like/{slug}','API\LikeController@getAll');



Route::post('/home/products/comment/{slug}','API\CommentController@storeProduct');
Route::get('/home/products/comment/{slug}','API\CommentController@getAllProduct');
Route::delete('/home/products/comment/{slug}/{id}','API\CommentController@destroyProduct');

Route::post('/home/products/like/{slug}','API\LikeController@storeProduct');
Route::get('/home/products/like/{slug}','API\LikeController@getAllProduct');



Route::group(['middleware' => ['auth:web']], function () {
    Route::apiResource('user', 'API\UserController');

    Route::get('/home/stats','API\HomeController@count_stats');

    
    Route::get('/cart/order/history','API\CartController@getOrderHistory');
    Route::get('/cart/order/purchase','API\CartController@getOrderPurchase');

    Route::get('/cart','API\CartController@getCart');
    Route::post('/cart','API\CartController@storeCart');
    Route::delete('/cart','API\CartController@deleteCart');
    Route::delete('/cart/{id}/{product_id}','API\CartController@deleteCartProduct');

    Route::put('/add-to-cart','API\CartController@storeAddToCart');
    // Route::post('/storePurchase','API\CartController@storePurchase');

    Route::get('/feedback','API\HomeController@getFeedback');

    Route::post('image-upload','API\PostController@imageUpload');
    
    Route::get('/posts/categories','API\PostController@getCategorys');
    Route::get('/posts/tags','API\PostController@getTags');
    Route::post('posts/check-slug','API\PostController@checkSlug');
    Route::apiResource('posts', 'API\PostController');
    

    Route::get('/products/categories','API\ProductController@getCategorys');
    Route::get('/products/tags','API\ProductController@getTags');
    Route::post('products/check-slug','API\ProductController@checkSlug');
    Route::apiResource('products', 'API\ProductController');
    

    Route::get('profile','API\UserController@profile');
    Route::put('profile','API\UserController@updateProfile');
});