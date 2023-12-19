<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookWSController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('logino', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
});

Route::group(['middleware' => ['jwt']], function($router){
    Route::group(['prefix' => 'books-ws'], function () {
        Route::get('/', [BookWSController::class, 'index'])->name('books-ws.index');
        Route::post('/', [BookWSController::class, 'store'])->name('books-ws.store');
        Route::get('/create', [BookWSController::class, 'create'])->name('books-ws.create');
        Route::get('/{book}', [BookWSController::class, 'show'])->name('books-ws.show');
        Route::put('/{book}', [BookWSController::class, 'update'])->name('books-ws.update');
        Route::delete('/{book}', [BookWSController::class, 'destroy'])->name('books-ws.destroy');
        Route::get('/{book}/edit', [BookWSController::class, 'edit'])->name('books-ws.edit');
    });
});
