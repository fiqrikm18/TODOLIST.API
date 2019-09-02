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

Route::get("/users", "UserController@index");
Route::get("/users/{id}", "UserController@getUserById");
Route::post("/users", "UserController@createUser");
Route::put("/users/{id}", "UserController@updateUser");
Route::delete("/users/{id}", "UserController@deleteUser");

Route::get("tasks/", "TaskController@index");
Route::get("tasks/{id}", "TaskController@getTaskByUser");
Route::get("tasks/{id}/{status}", "TaskController@getTaskByUserWithStatus");
Route::post("tasks", "TaskController@createTask");
Route::delete("task/{id}", "TaskController@deleteTask");
Route::put("tasks/{id}", "TaskController@updateTaskStatus");