<?php

// Admin area
Route::group(['namespace' => 'Admin'], function () {
    Route::get('/', function () {
        return redirect(route('admin.users.list'));
    })->name('admin');

    // Manage users
    Route::group(['middleware' => ['role:admin', 'permission:create-users,edit-users,delete-users']], function () {
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