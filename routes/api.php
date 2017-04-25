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

Route::group(['middleware' => 'auth.basic'], function () {
    Route::get('tasks/assigned', 'TaskController@getAssignedTasks');
    Route::post('tasks/{task}/assign', 'TaskController@assignTask');
    Route::resource('tasks', 'TaskController');

    Route::post('projects/{project}/restore', 'ProjectController@restoreProject');
    Route::resource('projects', 'ProjectController');

    Route::put('users/{user}', 'UserController@update')->middleware('can:update-user,user');
});