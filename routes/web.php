<?php

use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/form', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/products/view/{id}', [ProductController::class, 'show'])->name('products.view');
Route::get('/products/form/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/product/export/', [ProductController::class, 'export'])->name('products.export');

Route::put('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
Route::post('/products/bulk-delete', [ProductController::class, 'bulk_delete'])->name('products.bulk_delete');

Auth::routes();
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
