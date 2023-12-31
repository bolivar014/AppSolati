<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::resource('books', BookController::class);

Route::get('/login', function () {
    return view('login');
});

Route::get('/books', function () {
    return view('books');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
