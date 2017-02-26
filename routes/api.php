<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/v1/auth/login', 'Auth\AuthenticateController@authenticate');
Route::group(['prefix' => 'v1'], function () {
  Route::post('/auth/check', 'Auth\AuthenticateController@getAuthenticatedUser');

  Route::get('/devices', 'Devices\DevicesAPIController@get');
  Route::post('/devices', 'Devices\DevicesAPIController@create');

  Route::get('/visits', 'Visits\VisitsAPIController@get');
  Route::post('/visits', 'Visits\VisitsAPIController@create');
});
