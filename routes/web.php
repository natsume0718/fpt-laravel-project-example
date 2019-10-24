<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::namespace('Admin')->group(function () {

        Route::namespace('Users')->group(function () {
            Route::resource('users', 'UserController');
            Route::post('users/bulk', 'UserController@bulk')->name('users.bulk');
        });

        Route::namespace('Products')->group(function () {
            Route::resource('products', 'ProductController');
            Route::post('products/bulk', 'ProductController@bulk')->name('products.bulk');
        });

        Route::namespace('Products')->group(function () {
            Route::resource('product-categories', 'ProductCategoryController');
            Route::post('product-categories/bulk', 'ProductCategoryController@bulk')->name('product-categories.bulk');
        });
    });
});
