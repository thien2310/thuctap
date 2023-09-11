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



Route::get('/admin', 'common\DashboardController@index')->name('dash');
Route::get('/', 'pages\PageController@index')->name('page');




Route::group(['prefix' => 'Auth'], function () {
    Route::get('/login', 'Auth\AuthController@index')->name('auth.login');
    Route::post('/handleLogin', 'Auth\AuthController@Handlelogin')->name('auth.HandleLogin');
    Route::get('/signup', 'Auth\AuthController@signup')->name('auth.signup');
    Route::post('/', 'Auth\AuthController@HandleSingup')->name('auth.HandleSingup');
    Route::get('/logout', 'Auth\AuthController@logout')->name('auth.logout');
});



Route::group(['prefix' => 'admin'], function () {

    //danh muc
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/index', 'admin\CategoriesController@index')->name('categories.index');
        Route::get('/create', 'admin\CategoriesController@create')->name('categories.create');
        Route::post('/store', 'admin\CategoriesController@store')->name('categories.store');
        Route::get('/showedit/{id}', 'admin\CategoriesController@showedit')->name('categories.showedit');
        Route::post('/update/{id}', 'admin\CategoriesController@update')->name('categories.update');
        Route::get('/delete/{id}', 'admin\CategoriesController@deletel')->name('categories.delete');
        Route::get('/search', 'admin\CategoriesController@search')->name('categories.search');
        Route::get('/find/{id}', 'admin\CategoriesController@find')->name('categories.find');
        Route::get('/changestatus', 'admin\CategoriesController@changestatus')->name('categories.changestatus');
    });

    //banner

    Route::group(['prefix' => 'banner'], function () {
        Route::get('/index', 'admin\BannerController@index')->name('banner.index');
        Route::get('/create', 'admin\BannerController@create')->name('banner.create');
        Route::post('/store', 'admin\BannerController@store')->name('banner.store');
        Route::get('/edit/{id}', 'admin\BannerController@edit')->name('banner.edit');
        Route::post('/update/{id}', 'admin\BannerController@update')->name('banner.update');
        Route::get('/delete/{id}', 'admin\BannerController@delete')->name('banner.delete');
    });


    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('/index', 'admin\ProductController@index')->name('product.index');
        Route::get('/create', 'admin\ProductController@create')->name('product.create');
        Route::post('/store', 'admin\ProductController@store')->name('product.store');
        Route::get('/edit/{id}','admin\ProductController@edit')->name('product.edit');
        Route::post('/update/{id}','admin\ProductController@update')->name('product.update');

    });
    //tag
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/index', 'admin\TagController@index')->name('tag.index');
        Route::get('/create', 'admin\TagController@create')->name('tag.create');
        Route::post('/store', 'admin\TagController@store')->name('tag.store');


    });




});
