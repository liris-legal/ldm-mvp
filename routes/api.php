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

Route::prefix('v1')->group(function ($router) {
    Route::resource('lawsuits', 'API\LawsuitsApiController')->except(['create', 'edit']);
    Route::get('lawsuits/{lawsuit}/documents', 'API\DocumentApiController@index');
    Route::get('lawsuits/{lawsuit}/documents/{documents}', 'API\DocumentApiController@show');
    Route::resource('documents', 'API\DocumentApiController')->except(['create', 'edit']);

    Route::apiResources([
//        'lawsuits' => 'API\LawsuitsApiController',
    ]);
});
