<?php
/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/18
 * Time: 14:20
 */

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');
Route::get('/', ['as' => 'admin.index', 'uses' => 'DashboardController@index']);
Route::get('/getMenu', ['as' => 'admin.index', 'uses' => 'DashboardController@getMenu']);

Route::group(['middleware' => ['xss', 'auth:admin', 'permission', 'auth.admin']], function($router) {
    $router->get('index', ['as' => 'admin.index', 'uses' => 'IndexController@index']);
    $router->post('updatePassword', ['as' => 'admin.update-pwd', 'uses' => 'DashboardController@updatePassword']);

    //权限管理路由
    $router->get('permission/index/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    $router->get('permission/list/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@permissionList']); //查询
    $router->get('permission/create/{cid?}', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    $router->post('permission/store', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@store']);
    $router->get('permission/edit/{cid?}', ['as' => 'admin.permission.edit', 'uses' => 'PermissionController@edit']);
    $router->post('permission/update', ['as' => 'admin.permission.edit', 'uses' => 'PermissionController@update']);
    $router->post('permission/destroy/{id}', ['as' => 'admin.permission.destroy', 'uses' => 'PermissionController@destroy']);

    //角色管理路由
    $router->get('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    $router->get('role/list', ['as' => 'admin.role.index', 'uses' => 'RoleController@roleList']);
    $router->get('role/create', ['as' => 'admin.role.create', 'uses' => 'RoleController@create']);
    $router->post('role/store', ['as' => 'admin.role.create', 'uses' => 'RoleController@store']);
    $router->get('role/edit/{id}', ['as' => 'admin.role.edit', 'uses' => 'RoleController@edit']);
    $router->post('role/update', ['as' => 'admin.role.edit', 'uses' => 'RoleController@update']);
    $router->post('role/destroy/{id}', ['as' => 'admin.role.destroy', 'uses' => 'RoleController@destroy']);

    //用户管理路由
    $router->get('manager/index', ['as' => 'admin.manager.index', 'uses' => 'AdminController@index']);
    $router->get('manager/list', ['as' => 'admin.manager.index', 'uses' => 'AdminController@adminList']);
    $router->get('manager/create', ['as' => 'admin.manager.create', 'uses' => 'AdminController@create']);
    $router->post('manager/store', ['as' => 'admin.manager.create', 'uses' => 'AdminController@store']);
    $router->get('manager/edit/{id}', ['as' => 'admin.manager.edit', 'uses' => 'AdminController@edit']);
    $router->post('manager/update', ['as' => 'admin.manager.edit', 'uses' => 'AdminController@update']);
    $router->post('manager/destroy/{id}', ['as' => 'admin.manager.destroy', 'uses' => 'AdminController@destroy']);
});