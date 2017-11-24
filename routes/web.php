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

/**
 * Routes under 'auth' middleware
 */
Route::group(['middleware' => ['auth']], function () {
	Route::get('/', function () {
		return view('welcome');
	});

	Route::get('/home', function () {
		return redirect('brightcove');
	})->name('home');

    Route::group(['prefix' => 'brightcove', 'namespace' => 'Brightcove'], function () {
        Route::get('/', 'ContentController@index');
        Route::get('/videos', 'ContentController@videos');
        Route::get('/folders', 'ContentController@folders');
        Route::get('/folders/{folder}', 'ContentController@folder');
    });

	Route::group(['prefix' => 'reports'], function () {
		Route::get('/', function () {
			return redirect(route('search'));
		});
		Route::get('/search/{id?}', 'SearchController@index')->name('search');
		Route::post('/search', 'SearchController@indexRedirect');

		Route::get('/select/{id?}/{type?}', 'SearchController@select');
		Route::post('/select', 'SearchController@selectRedirect');

		Route::post('/show', 'ExcelController@index');
		Route::get('/track/{id?}/{option?}', 'TrackController@index');

    Route::post('/searchByTitle/{title?}', 'SearchByTitleController@index');
    Route::post('/report', 'BatchReportController@index');
	});

	// Ajax requests
	Route::post('/changeDbConnection', 'ConfigureController@changeDbConnection');
});

Auth::routes();

Route::match(['post', 'get'], 'register', function () {
    return redirect('login');
});
