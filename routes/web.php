<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::any('{slug}', function () {
//    return view('welcome');
//});

Route::get('/', 'Admin\AdminController@login');
Route::any('{slug}', 'Admin\AdminController@login');

Route::prefix('api')->middleware([AdminCheck::class])->group(function (){
    //Tag Routes Start
    Route::resource('/tag', 'Admin\TagController');
    //Category Routes Start
    Route::resource('/category', 'Admin\CategoryController');
    Route::post('/category/upload', 'Admin\CategoryController@uploadImage');
    Route::post('/category/image/delete', 'Admin\CategoryController@deleteImage');
    //Blog Routes Start
    Route::resource('/blog', 'Admin\BlogController');
    //Admin-User and Roles Routes Start
    Route::resource('/admin', 'Admin\AdminController');
    //Roles Route
    Route::get('/roles', 'Admin\AdminController@getRole');
    Route::post('/roles', 'Admin\AdminController@storeRole');
    Route::post('/roles/{id}', 'Admin\AdminController@updateRole');
    Route::get('/roles/delete/{id}', 'Admin\AdminController@destroyRole');
    Route::post('/permission', 'Admin\AdminController@permissionAssign');

    //Login and Logout Routes
    Route::post('/admin/login', 'Admin\AdminController@adminLogin');
    Route::get('/logout', 'Admin\AdminController@logout')->name('logout');
});

Route::post('/create-blog', 'Admin\BlogController@uploadEditorImage')->middleware([AdminCheck::class]);
