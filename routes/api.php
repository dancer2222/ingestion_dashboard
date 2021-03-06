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


//Route::group(['prefix' => 'brightcove', 'middleware' => ['api.brightcove.notifications'], 'namespace' => 'Brightcove'], function ($app) {
//    Route::post('/notifications', 'NotificationsController@updateStatus');
//});

Route::group(['prefix' => 'v1'], function() {
        Route::post('/tools/config', 'API\\V1\\Tools\\ConfigController@store');
});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
