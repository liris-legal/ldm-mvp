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
Auth::routes();

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('type-lawsuits', 'TypeLawsuitsController');
    Route::resource('lawsuits', 'LawsuitsController')->only(['index', 'create', 'edit']);
});

Route::get('/viewer', function () {
    return view('viewer');
});
