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

Route::fallback(function () {
    return response()->json(['error' => 'Not Found!'], 404);
});


//All routes for user API
Route::resource('users', 'UserController');

//All routes for task API
Route::resource('tasks', 'TaskController');

/*
+--------+-----------+-----------------------+---------------+---------------------------------------------+--------------+
| Domain | Method    | URI                   | Name          | Action                                      | Middleware   |
+--------+-----------+-----------------------+---------------+---------------------------------------------+--------------+
|        | POST      | api/tasks             | tasks.store   | App\Http\Controllers\TaskController@store   | api          |
|        | GET|HEAD  | api/tasks             | tasks.index   | App\Http\Controllers\TaskController@index   | api          |
|        | GET|HEAD  | api/tasks/create      | tasks.create  | App\Http\Controllers\TaskController@create  | api          |
|        | GET|HEAD  | api/tasks/{task}      | tasks.show    | App\Http\Controllers\TaskController@show    | api          |
|        | PUT|PATCH | api/tasks/{task}      | tasks.update  | App\Http\Controllers\TaskController@update  | api          |
|        | DELETE    | api/tasks/{task}      | tasks.destroy | App\Http\Controllers\TaskController@destroy | api          |
|        | GET|HEAD  | api/tasks/{task}/edit | tasks.edit    | App\Http\Controllers\TaskController@edit    | api          |
|                                                                                                                         | 
|        | GET|HEAD  | api/user              |               | Closure                                     | api,auth:api |
|                                                                                                                         |
|        | GET|HEAD  | api/users             | users.index   | App\Http\Controllers\UserController@index   | api          |
|        | POST      | api/users             | users.store   | App\Http\Controllers\UserController@store   | api          |
|        | GET|HEAD  | api/users/create      | users.create  | App\Http\Controllers\UserController@create  | api          |
|        | GET|HEAD  | api/users/{user}      | users.show    | App\Http\Controllers\UserController@show    | api          |
|        | PUT|PATCH | api/users/{user}      | users.update  | App\Http\Controllers\UserController@update  | api          |
|        | DELETE    | api/users/{user}      | users.destroy | App\Http\Controllers\UserController@destroy | api          |
|        | GET|HEAD  | api/users/{user}/edit | users.edit    | App\Http\Controllers\UserController@edit    | api          |
+--------+-----------+-----------------------+---------------+---------------------------------------------+--------------+
*/
