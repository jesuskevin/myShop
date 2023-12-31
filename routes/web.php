<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\PaymentsController;
use App\Http\Middleware\EnsureIsAdmin;
use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/books', [BooksController::class, 'index'])->name('books.index');

    Route::middleware(EnsureIsAdmin::class)->group(function () {
        Route::resource('books', BooksController::class)->except(['index']);
    });

    Route::get('/checkout/{book}', [PaymentsController::class, 'checkout'])->name('checkout');
});
