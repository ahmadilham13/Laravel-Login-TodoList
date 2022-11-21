<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\UserController;
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

Route::get("/", [HomeController::class, 'home']);

Route::view('/template', 'template');

Route::controller(UserController::class)->group(function() {
    Route::get('/login', 'login')->middleware('guest1');
    Route::post('/login', 'doLogin')->middleware('guest1');
    Route::post('/logout', 'doLogout')->middleware('member1');
});

Route::controller(TodoListController::class)
    ->middleware('member1')->group(function() {
        Route::get("/todolist", 'todoList');
        Route::post("/todolist", 'addTodo');
        Route::post("/todolist/{id}/delete", 'removeTodo');
    });