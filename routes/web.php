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
    return redirect('brightcove');
});

Route::get('/home', function () {
    return redirect('brightcove');
})->name('home');

/**
 * Routes under 'auth' middleware
 */
Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'brightcove', 'namespace' => 'Brightcove'], function () {
        Route::get('/', 'ContentController@index');
        Route::get('/videos', 'ContentController@videos');
        Route::get('/folders', 'ContentController@folders');
        Route::get('/folders/{folder}', 'ContentController@folder');
    });

});

Auth::routes();

Route::match(['post', 'get'], 'register', function () {
    return redirect('login');
});
