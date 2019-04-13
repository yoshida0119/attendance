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
Route::group(['middleware' => ['auth']], function () {
    // ユーザ一覧
    Route::resource('time', 'TimeController');
    Route::resource('time-multi', 'TimeMultiController');
    Route::resource('staff', 'StaffController');
    Route::resource('dept', 'DeptController');
    Route::get('time-show-month','TimeController@showMonth');
});
// Route::resource('top', 'TopController');
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
