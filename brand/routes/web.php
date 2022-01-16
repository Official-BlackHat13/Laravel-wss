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

Route::post('/get-states-by-country', 'DropdownController@getState')->name('get-states-by-country');
Route::post('/get-cities-by-state', 'DropdownController@getCity')->name('get-cities-by-state');
Route::post('/get-cities-by-state1', 'LocationController@getCity')->name('get-cities-by-state1');
Route::post('/get-category-by-super', 'DropdownController@getCategory')->name('get-category-by-super');
Route::post('/get-sub-by-category', 'DropdownController@getSubcat')->name('get-sub-by-category');
Route::post('/get-stores-by-city', 'DropdownController@getStore')->name('get-stores-by-city');
Route::post('/get-admin-by-store', 'DropdownController@getAdmin')->name('get-admin-by-store');
Route::post('/get-data-by-admin', 'DropdownController@getAdminData')->name('get-data-by-admin');
Route::post('/get-sales-by-admin', 'DropdownController@getAdminSales')->name('get-sales-by-admin');

//User routes start
Route::get('/users', 'UserController@index')->name('users');
Route::get('/edituser/{id}', 'UserController@edit')->name('edituser');
Route::post('/update-user', 'UserController@update')->name('update-user');
Route::get('/deleteuser/{id}', 'UserController@delete')->name('deleteuser');
Route::get('/changeuserstatus1/{id}', 'UserController@changeuserstatus1')->name('changeuserstatus1');
Route::get('/changeuserstatus2/{id}', 'UserController@changeuserstatus2')->name('changeuserstatus2');
//User routes end

//Banner routes start
Route::get('/banner', 'BannerController@getbannerDetails')->name('banner');
Route::get('/addbanner', 'BannerController@create')->name('addbanner');
Route::post('/postdtbanner','BannerController@store')->name('postdtbanner');
Route::get('/editbanner/{id}', 'BannerController@edit')->name('editbanner');
Route::get('/deletebanner/{id}', 'BannerController@delete')->name('deletebanner');
Route::post('/updatebanner', 'BannerController@update')->name('updatebanner');
Route::get('/changebannerstatus1/{id}', 'BannerController@changebannerstatus1')->name('changebannerstatus1');
Route::get('/changebannerstatus2/{id}', 'BannerController@changebannerstatus2')->name('changebannerstatus2');
Route::post('/multiple-banner-delete', 'BannerController@deleteMultiple')->name('multiple-banner-delete');
//Banner routes start

//offer Banner routes
Route::get('/offer-banner', 'OfferBannerController@index')->name('offer-banner');
Route::get('/add-offer-banner', 'OfferBannerController@create')->name('add-offer-banner');
Route::post('/postdtob','OfferBannerController@store')->name('postdtob');
Route::get('/edit-offer-banner/{id}', 'OfferBannerController@edit')->name('edit-offer-banner');
Route::get('/delete-offer-banner/{id}', 'OfferBannerController@delete')->name('delete-offer-banner');
Route::post('/update-offer-banner', 'OfferBannerController@update')->name('update-offer-banner');
Route::get('/changeobstatus1/{id}', 'OfferBannerController@changeobstatus1')->name('changeobstatus1');
Route::get('/changeobstatus2/{id}', 'OfferBannerController@changeobstatus2')->name('changeobstatus2');
Route::post('/multiple-ob-delete', 'OfferBannerController@deleteMultiple')->name('multiple-ob-delete');
//offer Banner end

//Winner Banner routes
Route::get('/winner-banner', 'WinnerBannerController@index')->name('winner-banner');
Route::get('/add-winner-banner', 'WinnerBannerController@create')->name('add-winner-banner');
Route::post('/postdtwb','WinnerBannerController@store')->name('postdtwb');
Route::get('/edit-winner-banner/{id}', 'WinnerBannerController@edit')->name('edit-winner-banner');
Route::get('/delete-winner-banner/{id}', 'WinnerBannerController@delete')->name('delete-winner-banner');
Route::post('/update-winner-banner', 'WinnerBannerController@update')->name('update-winner-banner');
Route::get('/changewbstatus1/{id}', 'WinnerBannerController@changewbstatus1')->name('changewbstatus1');
Route::get('/changewbstatus2/{id}', 'WinnerBannerController@changewbstatus2')->name('changewbstatus2');
Route::post('/multiple-wb-delete', 'WinnerBannerController@deleteMultiple')->name('multiple-wb-delete');
//Winner Banner end

//Coupons routes start
Route::get('/coupons', 'CouponController@getcouponsDetails')->name('coupons');
Route::get('/addcoupons', 'CouponController@create')->name('addcoupons');
Route::post('/postdtcoupons','CouponController@store')->name('postdtcoupons');
Route::get('/editcoupons/{id}', 'CouponController@edit')->name('editcoupons');
Route::get('/deletecoupons/{id}', 'CouponController@delete')->name('deletecoupons');
Route::post('/updatecoupons', 'CouponController@update')->name('updatecoupons');
Route::get('/changecouponsstatus1/{id}', 'CouponController@changecouponsstatus1')->name('changecouponsstatus1');
Route::get('/changecouponsstatus2/{id}', 'CouponController@changecouponsstatus2')->name('changecouponsstatus2');
//Coupons routes start

//Super Category routes start
Route::get('/super-category', 'SuperCategoryController@index')->name('super-category');
Route::get('/add-super-category', 'SuperCategoryController@create')->name('add-super-category');
Route::post('/postdtscat','SuperCategoryController@store')->name('postdtscat');
Route::get('/edit-super-category/{id}', 'SuperCategoryController@edit')->name('edit-super-category');
Route::get('/delete-super-category/{id}', 'SuperCategoryController@delete')->name('delete-super-category');
Route::post('/update-super-category', 'SuperCategoryController@update')->name('update-super-category');
Route::get('/changescatstatus1/{id}', 'SuperCategoryController@changescatstatus1')->name('changescatstatus1');
Route::get('/changescatstatus2/{id}', 'SuperCategoryController@changescatstatus2')->name('changescatstatus2');
//Super Category routes start

//Category routes start
Route::get('/category', 'CategoryController@index')->name('category');
Route::get('/add-category', 'CategoryController@create')->name('add-category');
Route::post('/postdtcat','CategoryController@store')->name('postdtcat');
Route::get('/edit-category/{id}', 'CategoryController@edit')->name('edit-category');
Route::get('/delete-category/{id}', 'CategoryController@delete')->name('delete-category');
Route::post('/update-category', 'CategoryController@update')->name('update-category');
Route::get('/changecatstatus1/{id}', 'CategoryController@changecatstatus1')->name('changecatstatus1');
Route::get('/changecatstatus2/{id}', 'CategoryController@changecatstatus2')->name('changecatstatus2');
//Category routes start

//Sub Category routes start
Route::get('/sub-category', 'SubCategoryController@index')->name('sub-category');
Route::get('/add-sub-category', 'SubCategoryController@create')->name('add-sub-category');
Route::post('/postdtsubcat','SubCategoryController@store')->name('postdtsubcat');
Route::get('/edit-sub-category/{id}', 'SubCategoryController@edit')->name('edit-sub-category');
Route::get('/delete-sub-category/{id}', 'SubCategoryController@delete')->name('delete-sub-category');
Route::post('/update-sub-category', 'SubCategoryController@update')->name('update-sub-category');
Route::get('/changesubcatstatus1/{id}', 'SubCategoryController@changesubcatstatus1')->name('changesubcatstatus1');
Route::get('/changesubcatstatus2/{id}', 'SubCategoryController@changesubcatstatus2')->name('changesubcatstatus2');
//Sub Category routes start

//location routes start
Route::get('/location', 'LocationController@index')->name('location');
Route::get('/add-location', 'LocationController@create')->name('add-location');
Route::post('/postdtlocation','LocationController@store')->name('postdtlocation');
Route::get('/edit-location/{id}', 'LocationController@edit')->name('edit-location');
Route::get('/delete-location/{id}', 'LocationController@delete')->name('delete-location');
Route::post('/update-location', 'LocationController@update')->name('update-location');
Route::get('/changelocstatus1/{id}', 'LocationController@changelocstatus1')->name('changelocstatus1');
Route::get('/changelocstatus2/{id}', 'LocationController@changelocstatus2')->name('changelocstatus2');
//location routes start

//brand admin routes
Route::get('/brand-admin', 'BrandAdminController@index')->name('brand-admin');
Route::get('/add-brand-admin', 'BrandAdminController@create')->name('add-brand-admin');
Route::post('/postdtbad','BrandAdminController@store')->name('postdtbad');
Route::get('/edit-brand-admin/{id}', 'BrandAdminController@edit')->name('edit-brand-admin');
Route::get('/delete-brand-admin/{id}', 'BrandAdminController@delete')->name('delete-brand-admin');
Route::post('/update-brand-admin', 'BrandAdminController@update')->name('update-brand-admin');
Route::get('/changebadminstatus1/{id}', 'BrandAdminController@changebadminstatus1')->name('changebadminstatus1');
Route::get('/changebadminstatus2/{id}', 'BrandAdminController@changebadminstatus2')->name('changebadminstatus2');
//brand admin routes end

//store admin routes
Route::get('/store-admin', 'StoreAdminController@index')->name('store-admin');
Route::get('/add-store-admin', 'StoreAdminController@create')->name('add-store-admin');
Route::post('/postdtsad','StoreAdminController@store')->name('postdtsad');
Route::get('/edit-store-admin/{id}', 'StoreAdminController@edit')->name('edit-store-admin');
Route::get('/delete-store-admin/{id}', 'StoreAdminController@delete')->name('delete-store-admin');
Route::post('/update-store-admin', 'StoreAdminController@update')->name('update-store-admin');
Route::get('/changesadminstatus1/{id}', 'StoreAdminController@changesadminstatus1')->name('changesadminstatus1');
Route::get('/changesadminstatus2/{id}', 'StoreAdminController@changesadminstatus2')->name('changesadminstatus2');
Route::post('/multiple-store-admin-delete', 'StoreAdminController@deleteMultiple')->name('multiple-store-admin-delete');
//store admin routes end

//product routes
Route::get('/product', 'ProductController@index')->name('product');
Route::get('/add-product', 'ProductController@create')->name('add-product');
Route::post('/postdtprd','ProductController@store')->name('postdtprd');
Route::get('/edit-product/{id}', 'ProductController@edit')->name('edit-product');
Route::get('/delete-product/{id}', 'ProductController@delete')->name('delete-product');
Route::post('/update-product', 'ProductController@update')->name('update-product');
Route::get('/changeprdstatus1/{id}', 'ProductController@changeprdstatus1')->name('changeprdstatus1');
Route::get('/changeprdstatus2/{id}', 'ProductController@changeprdstatus2')->name('changeprdstatus2');
Route::get('/delete-prd-img/{id}', 'ProductController@delete_img')->name('delete-prd-img');
Route::post('/multiple-product-delete', 'ProductController@deleteMultiple')->name('multiple-product-delete');
//product routes end

//Outlet  routes
Route::get('/outlet', 'OutletController@index')->name('outlet');
Route::get('/add-outlet', 'OutletController@create')->name('add-outlet');
Route::post('/postdtout','OutletController@store')->name('postdtout');
Route::get('/edit-outlet/{id}', 'OutletController@edit')->name('edit-outlet');
Route::get('/delete-outlet/{id}', 'OutletController@delete')->name('delete-outlet');
Route::post('/update-outlet', 'OutletController@update')->name('update-outlet');
Route::get('/changeoutstatus1/{id}', 'OutletController@changeoutstatus1')->name('changeoutstatus1');
Route::get('/changeoutstatus2/{id}', 'OutletController@changeoutstatus2')->name('changeoutstatus2');
Route::post('/multiple-outlet-delete', 'OutletController@deleteMultiple')->name('multiple-outlet-delete');
Route::get('/Liaison', 'OutletController@lision')->name('Liaison');
Route::post('/assign', 'OutletController@assign')->name('assign');
// end


Route::get('/view-account', 'HomeController@view_account')->name('view-account');
Route::get('/commercials', 'CommController@index')->name('commercials');

//Add Live stream
Route::get('/live-stream', 'LiveStreamController@index1')->name('live-stream');
Route::get('/add-live-stream', 'LiveStreamController@create')->name('add-live-stream');
Route::post('/storelive','LiveStreamController@storelive')->name('storelive');
Route::get('/edit-live-stream/{id}', 'LiveStreamController@editlive')->name('edit-live-stream');
Route::get('/delete-live-stream/{id}', 'LiveStreamController@deletelive')->name('delete-live-stream');
Route::post('/update-live-stream', 'LiveStreamController@updatelive')->name('update-live-stream');
Route::get('/changelivestatus1/{id}', 'LiveStreamController@changelivestatus1')->name('changelivestatus1');
Route::get('/changelivestatus2/{id}', 'LiveStreamController@changelivestatus2')->name('changelivestatus2');
Route::post('/multiple-live-stream-delete', 'LiveStreamController@deleteMultiplelive')->name('multiple-live-stream-delete');

Route::get('/promos', 'LiveStreamController@index')->name('promos');
Route::get('/add-promo', 'LiveStreamController@create1')->name('add-promo');
Route::post('/storepromo','LiveStreamController@storepromo')->name('storepromo');
Route::get('/edit-promo/{id}', 'LiveStreamController@edit')->name('edit-promo');
Route::get('/delete-promo/{id}', 'LiveStreamController@delete')->name('delete-promo');
Route::post('/update-promo', 'LiveStreamController@update')->name('update-promo');
Route::get('/changepromostatus1/{id}', 'LiveStreamController@changepromostatus1')->name('changepromostatus1');
Route::get('/changepromostatus2/{id}', 'LiveStreamController@changepromostatus2')->name('changepromostatus2');
Route::post('/multiple-promo-delete', 'LiveStreamController@deleteMultiple')->name('multiple-promo-delete');

Route::get('/staff-updates', 'LiveStreamController@staff')->name('staff-updates');
Route::get('/add-staff-update', 'LiveStreamController@createstaff')->name('add-staff-update');
Route::post('/storestaff','LiveStreamController@storestaff')->name('storestaff');
Route::get('/edit-staff/{id}', 'LiveStreamController@editstaff')->name('edit-staff');
Route::get('/delete-staff/{id}', 'LiveStreamController@deletestaff')->name('delete-staff');
Route::post('/update-staff', 'LiveStreamController@updatestaff')->name('update-staff');
Route::get('/changeupdatestatus1/{id}', 'LiveStreamController@changestaffstatus1')->name('changeupdatestatus1');
Route::get('/changeupdatestatus2/{id}', 'LiveStreamController@changestaffstatus2')->name('changeupdatestatus2');
Route::post('/multiple-staff-delete', 'LiveStreamController@deleteMultiplestaff')->name('multiple-staff-delete');
//End

//User and staff Interaction
Route::get('/user-staff-interaction', 'PerformanceController@index')->name('user-staff-interaction');
Route::get('/staff-performance', 'PerformanceController@staffindex')->name('staff-performance');
Route::get('/sales-performance', 'PerformanceController@salesindex')->name('sales-performance');
//End