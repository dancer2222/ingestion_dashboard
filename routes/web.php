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
    return redirect('dashboard');
});

Route::get('/home', function () {
    return redirect('dashboard');
})->name('home');

/**
 * Routes under 'auth' middleware
 */
Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'dashboard', 'namespace' => 'Brightcove'], function () {
        Route::get('/', 'ContentController@index');
        Route::get('/videos', 'ContentController@videos');
        Route::get('/folders', 'ContentController@folders');
        Route::get('/folders/{folder}', 'ContentController@folder');
    });


    Route::get('/search/{id?}', 'SearchController@index')->name('search');
    Route::post('/search', 'SearchController@indexRedirect');

    Route::get('/select/{id?}/{type?}', 'SearchController@select');
    Route::post('/select', 'SearchController@selectRedirect');

    Route::post('/show', 'ExcelController@index');

    Route::post('/searchByTitle/{title?}', 'SearchByTitleController@index');

	// Ajax requests
	Route::post('/changeDbConnection', 'ConfigureController@changeDbConnection');
});

Auth::routes();

Route::match(['post', 'get'], 'register', function () {
    return redirect('login');
});
