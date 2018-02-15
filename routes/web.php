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
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function() {
        return view('welcome');
    });
    Route::get('/home', function() {
        return redirect('brightcove');
    })->name('home');

    Route::group(['prefix' => 'brightcove', 'namespace' => 'Brightcove'], function() {
        Route::get('/', 'ContentController@index');
        Route::get('/videos', 'ContentController@videos');
        Route::get('/folders', 'ContentController@folders');
        Route::get('/folders/{folder}', 'ContentController@folder');
    });

    Route::group(['prefix' => 'reports'], function() {

        Route::get('/', function() {
            return redirect(route('search'));
        });
        //Select search
        Route::get('/sel', 'SelectController@index')->name('sel');

        Route::get('/search/{id?}/{type?}', 'SearchController@index')->name('search');
        Route::post('/search', 'SearchController@indexRedirect');

        Route::post('/show', 'ParseController@index');
        Route::get('/track/{id?}/{option?}', 'TrackController@index');

        Route::post('/searchBy/{title?}', 'SearchByController@index');
        Route::post('/report', 'BatchReportController@index');
    });

    Route::group(['prefix' => 'aws'], function() {
        Route::get('/show', 'Aws\\AwsNotificationsController@index');
    });

    //Tools route
    Route::group(['prefix' => 'tools'], function() {
        Route::get('/', function() {
            return redirect(route('tools'));
        });
        Route::get('/select', 'ToolsController@index')->name('tools.index');
        Route::post('/select/{command?}', 'ToolsController@doIt')->name('tools.do');
    });

    //Ajax requests
    Route::post('/changeDbConnection', 'ConfigureController@changeDbConnection');
});

Auth::routes();

Route::match(['post', 'get'], 'register', function() {
    return redirect('login');
});
