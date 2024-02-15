<?php

use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    //login
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
    //register
    Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
    
    
    Route::middleware('auth:sanctum')->group(function(){
        //logout
        Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('profile', [AuthController::class, 'profile'])->name('auth.profile');
        Route::post('change-password', [AuthController::class, 'changePassword'])->name('auth.change.password');
        Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('auth.update.profile');
        //books
        Route::get('todos', [TodoController::class, 'index'])->name('todos');
        Route::get('todos/statistic', [TodoController::class, 'statistic'])->name('todos.statistic');
        Route::prefix('todo')->group(function(){
            Route::get('{id}/show', [TodoController::class, 'show'])->name('todo.show');
            Route::post('store', [TodoController::class, 'store'])->name('todo.store');
            Route::get('{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
            Route::put('{id}/update', [TodoController::class, 'update'])->name('todo.update');
            Route::delete('{id}/delete', [TodoController::class, 'destroy'])->name('todo.delete');
            Route::get('{id}/completed', [TodoController::class, 'toggleComplete'])->name('todo.completed');
        });
        
    });
});

