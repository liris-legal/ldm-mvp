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
    Route::resource('lawsuits', 'LawsuitsController')->only(['index', 'create', 'edit', 'show']);
    Route::get('lawsuits/{lawsuit}/documents', 'LawsuitsController@documentsShow')->name('lawsuits.documents.show');

    Route::get('lawsuits/{lawsuit}/{submitter}/documents', 'DocumentController@index')->name('documents.index');
    Route::get('lawsuits/{lawsuit}/documents/create', 'DocumentController@create')->name('documents.create');
    Route::get('lawsuits/{lawsuit}/documents/{documents}/edit', 'DocumentController@edit')->name('documents.edit');

    Route::get('/iframe', 'HomeController@show');
});

Route::get('/viewer', function () {
    return view('viewer');
});
