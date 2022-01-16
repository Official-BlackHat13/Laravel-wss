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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/logout', function () {
    return redirect('login');
});

Auth::routes();
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::get('/product', 'ProductController@index')->name('product');
Route::get('/edit-product/{id}', 'ProductController@edit')->name('edit-product');
Route::get('/delete-product/{id}', 'ProductController@delete')->name('delete-product');
Route::post('/update-product', 'ProductController@update')->name('update-product');
Route::get('/changeprdstatus1/{id}', 'ProductController@changeprdstatus1')->name('changeprdstatus1');
Route::get('/changeprdstatus2/{id}', 'ProductController@changeprdstatus2')->name('changeprdstatus2');
Route::get('/delete-prd-img/{id}', 'ProductController@delete_img')->name('delete-prd-img');
Route::post('/multiple-product-delete', 'ProductController@deleteMultiple')->name('multiple-product-delete');

