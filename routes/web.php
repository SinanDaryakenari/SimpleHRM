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

//Route::get('/test', 'TestController@test');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index');

    /** Admin */
    Route::middleware('can:admin')->group(function(){
        /** User CRUD */
        Route::get('/admin/users', 'Admin\UserController@index');
        Route::post('/admin/user/list', 'Admin\UserController@list');
        Route::post('/admin/user/save', 'Admin\UserController@store');
        Route::post('/admin/user/update', 'Admin\UserController@update');
        Route::post('/admin/user/delete', 'Admin\UserController@destroy');
        /** Role Assignment to User */
        Route::get('/admin/user/role', 'Admin\RoleController@have');
        Route::post('/admin/user/role/list', 'Admin\RoleController@haveList');
        Route::post('/admin/user/has-no-role/option', 'Admin\RoleController@hasNoRole');
        Route::post('/admin/user/assign/role', 'Admin\RoleController@assignRole');
        Route::post('/admin/user/revoke/role', 'Admin\RoleController@revokeRole');
        Route::post('/admin/role/list', 'Admin\RoleController@list');
        /** Designation CRUD*/
        Route::get('/admin/designation', 'Admin\DesignationController@index');
        Route::post('/admin/designation/list', 'Admin\DesignationController@list');
        Route::post('/admin/designation/save', 'Admin\DesignationController@store');
        Route::post('/admin/designation/update', 'Admin\DesignationController@update');
        Route::post('/admin/designation/delete', 'Admin\DesignationController@destroy');

    });


});




