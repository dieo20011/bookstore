<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ProductController;



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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::prefix('/DetailBook')->name('detailbook')->group(
    function() {
        Route::get('/{id}', [HomeController::class, 'loadDetailProduct']);
    }
); 
Route::prefix('/Cart')->name('cart')->group(
    function() {
        Route::get('/{id}', [CartController::class, 'loadDetailProduct']);
    }
); 
Route::middleware('checkLogin')->prefix('Admin')->name('admin')->group(
   function() {
    Route::get('/', [AdminController::class, 'index']);
   } 
);
Route::middleware('checkLogin')->prefix('Admin/Author')->name('author.')->group(
    function() {
        Route::match(['get', 'post'], '/', [AuthorController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [AuthorController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [AuthorController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [AuthorController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [AuthorController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [AuthorController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [AuthorController::class, 'delete'])->name('delete');

    }
);
Route::middleware('checkLogin')->prefix('Admin/Supplier')->name('supplier.')->group(
    function() {
        Route::match(['get', 'post'], '/', [SupplierController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [SupplierController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [SupplierController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [SupplierController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [SupplierController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [SupplierController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [SupplierController::class, 'delete'])->name('delete');

    }
);
Route::middleware('checkLogin')->prefix('Admin/Publisher')->name('publisher.')->group(
    function() {
        Route::match(['get', 'post'], '/', [PublisherController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [PublisherController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [PublisherController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [PublisherController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [PublisherController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [PublisherController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [PublisherController::class, 'delete'])->name('delete');

    }
);
Route::middleware('checkLogin')->prefix('Admin/Promotion')->name('promotion.')->group(
    function() {
        Route::match(['get', 'post'], '/', [PromotionController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [PromotionController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [PromotionController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [PromotionController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [PromotionController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [PromotionController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [PromotionController::class, 'delete'])->name('delete');

    }
);
Route::middleware('checkLogin')->prefix('Admin/Product')->name('product.')->group(
    function() {
        Route::match(['get', 'post'], '/', [ProductController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [ProductController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [ProductController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [ProductController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [ProductController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [ProductController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [ProductController::class, 'delete'])->name('delete');
        // Route::match(['get', 'post'], '/select', [ProductController::class, 'selectForMenu'])->name('select');
    }
);
Route::prefix('Admin/Product')->name('product.')->group(
    function() {
        Route::match(['get', 'post'], '/select', [ProductController::class, 'selectForMenu'])->name('select');
    }
);

Route::middleware('checkLogin')->prefix('Admin/Category')->name('category.')->group(
    function() {
        Route::match(['get', 'post'], '/', [CategoryController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [CategoryController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [CategoryController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [CategoryController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [CategoryController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [CategoryController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [CategoryController::class, 'delete'])->name('delete');

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

Route::middleware('checkLogin')->prefix('Admin/Import')->name('import.')->group(
    function() {
        Route::match(['get', 'post'], '/', [ImportController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/Pagination', [ImportController::class, 'pagination'])->name('pagination');
        Route::match(['get', 'post'], '/show/{id}', [ImportController::class, 'show'])->name('show');
        Route::match(['get', 'post'], '/edit', [ImportController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/store', [ImportController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/add', [ImportController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/delete', [ImportController::class, 'delete'])->name('delete');
        Route::match(['get', 'post'], '/addImportTemp', [ImportController::class, 'addImportTemp'])->name('addImportTemp');
        Route::match(['get', 'post'], '/showFormImportDetail', [ImportController::class, 'showFormImportDetail'])->name('showFormImportDetail');
        Route::match(['get', 'post'], '/updateDetailImport', [ImportController::class, 'updateDetailImport'])->name('updateDetailImport');
        Route::match(['get', 'post'], '/showDetail', [ImportController::class, 'showDetail'])->name('showDetail');

        
        
    
    }
);
