<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('index');
});

Route::middleware('checkLogin')->prefix('Admin')->name('admin')->group(
   function() {
    Route::get('/', [AdminController::class, 'index']);
   } 
);

Route::middleware('checkLogin')->prefix('Admin/Category')->name('category.')->group(
    function() {
        Route::match(['get', 'post'], '/', [CategoryController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/show/{id}', [CategoryController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit/{id}', [CategoryController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [CategoryController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [CategoryController::class, 'add'])->name('add');

    }
);

Route::middleware('checkLogin')->prefix('Admin/Menu')->name('menu.')->group(
    function() {
        Route::match(['get', 'post'], '/', [MenuController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [MenuController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [MenuController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [MenuController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [MenuController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [MenuController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [MenuController::class, 'delete'])->name('delete');

    }
);
