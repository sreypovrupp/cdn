<?php

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
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('customer')->group(function (){
    Route::get('/', 'CustomerController@index')->name('customer.index');
    Route::post('/', 'CustomerController@store')->name('customer.store');
    Route::get('/rows', 'CustomerController@rows')->name('customer.rows');//Pagination
    Route::put('/{id}', 'CustomerController@update')->name('customer.update');
    Route::delete('/{id}', 'CustomerController@destroy')->name('customer.destroy');
});

Route::prefix('category')->group(function (){
    Route::get('/', 'Food\CategoryController@index')->name('category.index');
    //Route::post('/', 'Food\CategoryController@store')->name('category.store');
    Route::get('/rows', 'Food\CategoryController@rows')->name('category.rows');//Pagination
    //Route::put('/{id}', 'Food\CategoryController@update')->name('category.update');
    //Route::delete('/{id}', 'Food\CategoryController@destroy')->name('category.destroy');
});

Route::prefix('product')->group(function (){
    Route::get('/', 'Food\ProductController@index')->name('product.index');
    Route::get('/rows', 'Food\ProductController@rows')->name('product.rows');//Pagination

    Route::post('/', 'Food\ProductController@save')->name('product.save');
});



