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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login','apiservices\AppservicesController@login');
Route::post('register','apiservices\AppservicesController@register');
Route::post('forgot-password-sent-otp','apiservices\AppservicesController@forgot_password_sent_otp');
Route::post('check-otp','apiservices\AppservicesController@check_otp');
Route::post('update-password','apiservices\AppservicesController@update_password');
Route::post('change-password','apiservices\AppservicesController@change_password');
Route::post('delete-account','apiservices\AppservicesController@delete_account');
Route::post('profile-details','apiservices\AppservicesController@profile_details');
Route::post('edit-profile-details','apiservices\AppservicesController@edit_profile_details');
Route::post('location-list','apiservices\AppservicesController@location_list');
Route::post('location-pincode','apiservices\AppservicesController@location_pincode');
Route::post('fetch-category','apiservices\AppservicesController@fetch_category');
Route::post('fetch-sub-category','apiservices\AppservicesController@fetch_sub_category');
Route::post('fetch-product-list','apiservices\AppservicesController@fetch_product_list');
Route::post('category-home-page','apiservices\AppservicesController@category_home_page');
Route::post('sort-by','apiservices\AppservicesController@sort_by');
Route::post('product-details','apiservices\AppservicesController@product_details');
Route::post('filters','apiservices\AppservicesController@filters');
Route::post('add-cart','apiservices\AppservicesController@add_cart');
Route::post('delete-cart','apiservices\AppservicesController@delete_cart');
Route::post('update-cart-quantity','apiservices\AppservicesController@update_cart_quantity');
Route::post('move-to-wishlist','apiservices\AppservicesController@move_to_wishlist');
Route::post('add-wishlist','apiservices\AppservicesController@add_wishlist');
Route::post('move-to-cart','apiservices\AppservicesController@move_to_cart');
Route::post('delete-wishlist','apiservices\AppservicesController@delete_wishlist');
Route::post('fetch-cart','apiservices\AppservicesController@fetch_cart');
Route::post('fetch-wishlist','apiservices\AppservicesController@fetch_wishlist');
Route::post('search','apiservices\AppservicesController@search');
Route::post('user-address','apiservices\AppservicesController@check_address');
Route::post('add-address','apiservices\AppservicesController@add_address');
Route::post('update-address','apiservices\AppservicesController@update_address');
Route::post('delete-address','apiservices\AppservicesController@delete_address');
Route::post('add-coupon','apiservices\AppservicesController@apply_coupon');
Route::post('add-review','apiservices\AppservicesController@add_review');
Route::post('checkout','apiservices\AppservicesController@checkout');
Route::post('order','apiservices\AppservicesController@order_generation');
Route::post('order-history','apiservices\AppservicesController@get_order_info');


// store App Api's

Route::post('store-login','apiservices\StoreServicesController@store_login');
Route::post('store-forgot-password-sent-otp','apiservices\StoreServicesController@store_forgot_password_sent_otp');
Route::post('store-check-otp','apiservices\StoreServicesController@store_check_otp');
Route::post('store-update-password','apiservices\StoreServicesController@store_update_password');
Route::post('store-change-password','apiservices\StoreServicesController@store_change_password');
Route::post('store-delete-account','apiservices\StoreServicesController@store_delete_account');
Route::post('store-profile-details','apiservices\StoreServicesController@store_profile_details');
Route::post('store-edit-profile-details','apiservices\StoreServicesController@store_edit_profile_details');
Route::post('store-location-list','apiservices\StoreServicesController@store_location_list');