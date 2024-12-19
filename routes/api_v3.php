<?php

use App\Http\Controllers\Api\V3\CategoryController;
use App\Http\Controllers\Api\V3\ProductController;
use App\Http\Controllers\Api\V3\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('lists/categories', [CategoryController::class,  'list']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::get('products', [ProductController::class,  'index'])
        ->middleware('throttle:products');
});

Route::get('/subcategories', [SubcategoryController::class, 'index']);
