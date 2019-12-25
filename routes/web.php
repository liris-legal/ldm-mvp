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
Route::post('register', 'Auth\RegisterController@register')->name('auth.register');


Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/folders', 'HomeController@folder')->name('folders');

    Route::resource('cases', 'CasesController');
});
