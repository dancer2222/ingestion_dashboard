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

// Monitor
Route::get('/monitor', function () {
    return response()->json([
       'ingestion_dashboard_api' => 'ok',
       'version' => 'unknown',
    ]);
});

/**
 * Routes under 'auth' middleware
 */
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function() {
        return view('template_v2.welcome');
    });

    // Brightcove
    Route::group(['prefix' => 'brightcove', 'namespace' => 'Brightcove', 'middleware' => ['brightcove', 'role:admin|tester|pm|ingester']], function() {
        Route::get('/', 'ContentController@index')->name('brightcove.index');
        Route::get('/videos', 'ContentController@videos')->name('brightcove.videos');
        Route::get('/folders', 'ContentController@folders')->name('brightcove.folders');
        Route::get('/folders/{folder}', 'ContentController@folder')->name('brightcove.folder');
    });

    // Search v2
    Route::name('reports.')->prefix('search/v2')->namespace('Search')->group(function () {
        Route::get('/{mediaType}', 'SearchController@index')->name('index')->where(['mediaType' => '(audiobooks|books|movies)']);
        Route::get('/{mediaType}/{needle}', 'SearchController@show')->name('show')->where(['mediaType' => '(audiobooks|books|movies)']);
    });

    Route::name('webApi.')->prefix('web/content')->namespace('API\V1\Content')->group(function () {
        // Audiobooks
        Route::name('audiobooks.')->prefix('audiobooks')->group(function () {
            Route::post('status', 'AudiobooksController@setStatus')->name('setStatus');
        });
    });

    // Reports
    Route::group(['prefix' => 'reports'], function() {

        Route::get('/', function() {
            return redirect(route('search'));
        });
        //Select search
        Route::get('/search/{contentType?}/{valueType?}/{value?}', 'SearchController@index')->name('search');

        Route::post('/show', 'ParseController@index')->name('reports.parse.index');
        Route::post('/metadata', 'ParseController@getMetadataIntoDatabase')->name('reports.parse.getMetadataIntoDatabase');
        Route::get('/track/{id?}', 'TrackController@index')->name('reports.track.index');

        Route::post('/searchBy/{title?}', 'SearchByController@index')->name('reports.search_by_title');
        Route::post('/report', 'BatchReportController@index')->name('reports.batch_report');
    });

    Route::group(['prefix' => 'aws', 'middleware' => 'role:admin|ingester|pm', 'namespace' => 'Aws'], function() {
        Route::get('/notifications', 'AwsNotificationsController@index')->name('aws.index');
    });

    //Tools route
    Route::group(['prefix' => 'tools', 'middleware' => 'role:admin|ingester'], function() {
        Route::get('/', 'ToolsController@index')->name('tools.index');
        Route::post('/select/{command?}', 'ToolsController@doIt')->name('tools.do');
        Route::post('/optionFromFile', 'ToolsController@optionValueFromFile')->name('tools.optionFromFile');
    });

    //Ajax requests
    //Route::post('/changeDbConnection', 'ConfigureController@changeDbConnection');

    // Ingestion tools
    Route::group(['prefix' => 'ingestion', 'middleware' => 'role:admin|ingester', 'namespace' => 'Ingestion'], function () {
        // Rabbitmq
        Route::group(['prefix' => 'rabbitmq', 'namespace' => 'Rabbitmq'], function () {
            Route::group(['prefix'=> 'indexation'], function () {
                Route::get('/', 'IndexationController@index')->name('indexation.index');
                Route::post('/', 'IndexationController@store')->name('indexation.store');
            });
        });
    });

    // TODO: rename status to something more suitable
    Route::group(['prefix' => 'status', 'middleware' => 'role:admin|ingester', 'namespace' => 'Status'], function() {
        Route::post('/changeStatus', 'StatusController@changeStatus')->name('changeStatus');
    });

    // Blacklist
    Route::group(['prefix' => 'blackList', 'namespace' => 'BlackList'], function() {
        Route::get('/', 'BlackListController@index')->name('blackList.index');
        Route::get('/search/{mediaType}', 'BlackListController@getInfoFromBlackList')->name('blackList.getInfoFromBlackList');
        Route::get('/manage', 'BlackListController@indexManage')->name('blackList.manage');
        Route::post('/blackList', 'BlackListController@blackList')->name('blackList.blackList');
        Route::post('/blackListSelect', 'BlackListController@blackListSelect')->name('blackList.blackListSelect');
    });

    // Ratings
    Route::name('ratings.')->prefix('ratings')->namespace('Ratings')->group(function () {
        Route::get('/{content_type}', 'RatingsController@index')->name('index');
    });

    // Authors Search
    Route::name('authors.')->prefix('authors')->namespace('Authors')->group(function () {
        Route::get('/', 'AuthorsController@index')->name('index');
        Route::get('/{id}', 'AuthorsController@show')->name('show');
    });

    // Licensors Search
    Route::name('licensors.')->prefix('licensors')->namespace('Licensors')->group(function () {
        Route::get('/', 'LicensorsController@index')->name('index');
        Route::get('/{id}', 'LicensorsController@show')->name('show');
    });
});

Auth::routes();

Route::any('register', function() {
    return redirect(route('login'));
});

Route::get('social/auth/{provider}', 'Auth\\SocialController@redirectToProvider')->name('social.auth');
Route::get('social/callback/{provider}', 'Auth\\SocialController@handleProviderCallback')->name('social.callback');

Route::get('auth/google/login', 'Auth\\LoginGoogleController@login')->name('google.login');
Route::get('auth/google/callback', 'Auth\\LoginGoogleController@callback')->name('google.callback');