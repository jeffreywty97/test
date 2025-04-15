<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::apiResource('cateogry', CategoryController::class);
Route::apiResource('product', ProductController::class);
Route::post('product/bulk_delete', [ProductController::class, 'bulk_delete']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');