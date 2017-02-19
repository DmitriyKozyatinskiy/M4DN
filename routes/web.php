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

Auth::routes();

Route::get('/', function () {
    return view('layouts/app');
})->middleware('login');

Route::get('/account/settings', function () {
    return view('account/settings');
})->middleware('login')
  ->name('account/settings');
Route::post('/account/settings', 'Account\AccountController@save')
  ->middleware('login');

Route::get('/account/subscription', 'Account\SubscriptionController@show')
  ->middleware('login')
  ->name('subscription/show');
Route::post('/account/subscription', 'Account\SubscriptionController@setActive')
  ->middleware('login');

Route::get('/devices/show', 'Devices\DevicesController@show')
  ->middleware('login')
  ->name('devices/show');
Route::get('/devices/update/{id?}', 'Devices\DevicesController@update')
  ->middleware('login');
Route::post('/devices/update', 'Devices\DevicesController@save')
  ->middleware('login');
Route::post('/devices/delete', 'Devices\DevicesController@delete')
  ->middleware('login');
Route::get('/devices/delete', function () {
  return view('devices/remove');
})->middleware('login');

Route::get('/admin/subscription/{id?}', 'Admin\SubscriptionController@show')
  ->middleware('admin');
Route::post('/admin/subscription', 'Admin\SubscriptionController@save')
  ->middleware('admin');