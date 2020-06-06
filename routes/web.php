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

// Route::get('/', function () {
//     return view('re');
// });
Route::get('/',  'HomeController@home');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/market', 'HomeController@market')->name('market');


Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/manage/{vue_capture}', function () {
        return view('layouts.master');
    });
    Route::get('/manage/{first}/{second}', function () {
        return view('layouts.master');
    });
    Route::get('/manage/{first}/{second}/{third}', function () {
        return view('layouts.master');
    });

});

Route::get('/{vue_capture}',  'HomeController@home')->name('recipe');
Route::get('/{first}/{second}',  'HomeController@home');