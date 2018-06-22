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
    Route::get('/home', function() {
        return redirect(route('brightcove.index'));
    })->name('home');

    // Admin area
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => []], function () {
        Route::get('/', function () {
            return redirect(route('admin.users.list'));
        })->name('admin');

        // Manage users
        Route::group(['middleware' => 'permission:create-users,edit-users,delete-users'], function () {
            Route::get('/users', 'UsersController@list')->name('admin.users.list');
            Route::get('/users/{id}/edit', 'UsersController@showEdit')->name('admin.users.showEdit');
            Route::post('/users/{id}/edit', 'UsersController@edit')->name('admin.users.edit');
            Route::post('/users/{id}/delete', 'UsersController@delete')->name('admin.users.delete');
            Route::get('/users/create', 'UsersController@showCreate')->name('admin.users.showCreate');
            Route::post('/users/create', 'UsersController@create')->name('admin.users.create');
        });

        Route::group(['middleware' => ['role:admin']], function () {

            // Manage Roles
            Route::get('/roles', 'RolesController@list')->name('admin.roles.list');
            Route::get('/roles/{id}/edit', 'RolesController@showEdit')->name('admin.roles.showEdit');
            Route::post('/roles/{id}/edit', 'RolesController@edit')->name('admin.roles.edit');
            Route::post('/roles/{id}/delete', 'RolesController@delete')->name('admin.roles.delete');
            Route::get('/roles/create', 'RolesController@showCreate')->name('admin.roles.showCreate');
            Route::post('/roles/create', 'RolesController@create')->name('admin.roles.create');

            // Manage Permissions
            Route::get('/permissions', 'PermissionsController@list')->name('admin.permissions.list');
            Route::get('/permissions/{id}/edit', 'PermissionsController@showEdit')->name('admin.permissions.showEdit');
            Route::post('/permissions/{id}/edit', 'PermissionsController@edit')->name('admin.permissions.edit');
            Route::post('/permissions/{id}/delete', 'PermissionsController@delete')->name('admin.permissions.delete');
            Route::get('/permissions/create', 'PermissionsController@showCreate')->name('admin.permissions.showCreate');
            Route::post('/permissions/create', 'PermissionsController@create')->name('admin.permissions.create');
        });
    });

    // Brightcove
    Route::group(['prefix' => 'brightcove', 'namespace' => 'Brightcove', 'middleware' => ['brightcove', 'role:admin|tester|pm']], function() {
        Route::get('/', 'ContentController@index')->name('brightcove.index');
        Route::get('/videos', 'ContentController@videos')->name('brightcove.videos');
        Route::get('/folders', 'ContentController@folders')->name('brightcove.folders');
        Route::get('/folders/{folder}', 'ContentController@folder')->name('brightcove.folder');
    });

    // Reports
    Route::group(['middleware' => 'role:admin|tester', 'prefix' => 'reports'], function() {

        Route::get('/', function() {
            return redirect(route('search'));
        });
        //Select search
        Route::get('/sel', 'SelectController@index')->name('sel');
        Route::get('/search/{id?}/{type?}', 'SearchController@index')->name('search');

        Route::post('/show', 'ParseController@index')->name('reports.parse.index');
        Route::post('/metadata', 'ParseController@getMetadataIntoDatabase')->name('reports.parse.getMetadataIntoDatabase');
        Route::get('/track/{id?}/{option?}', 'TrackController@index')->name('reports.track.index');

        Route::post('/searchBy/{title?}', 'SearchByController@index')->name('reports.search_by_title');
        Route::post('/report', 'BatchReportController@index')->name('reports.batch_report');
    });

    Route::group(['prefix' => 'aws', 'middleware' => 'role:admin|ingester', 'namespace' => 'Aws'], function() {
        Route::get('/show/', 'AwsNotificationsController@index')->name('aws.index');
        Route::post('/showSelect/{date?}', 'AwsNotificationsController@getInfo')->name('aws.info');
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

    Route::group(['prefix' => 'blackList', 'middleware' => 'role:admin|ingester', 'namespace' => 'BlackList'], function() {
        Route::get('/add', 'BlackListController@indexAdd')->name('blackList.indexAdd');
        Route::post('/blackList', 'BlackListController@blackList')->name('blackList.blackList');
        Route::get('/remove', 'BlackListController@indexRemove')->name('blackList.indexRemove');
    });

    Route::group(['prefix' => 'status', 'middleware' => 'role:admin|ingester', 'namespace' => 'Status'], function() {
        Route::post('/changeStatus', 'ChangeStatusController@changeStatus')->name('changeStatus');
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