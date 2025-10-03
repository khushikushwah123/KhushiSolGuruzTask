<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\{ProductController,UserController};

Route::match(['GET', 'POST'], 'administrator', [AdminController::class, 'index']);

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('logout', [AdminController::class, 'logout']);

    // Product
    Route::match(['GET', 'POST'], 'products', [ProductController::class, 'index']);
    Route::match(['GET', 'POST'], 'add-product', [ProductController::class, 'create']);
    Route::match(['GET', 'POST'], 'edit-product/{id}', [ProductController::class, 'edit']);
    Route::match(['GET', 'POST'], 'view-product/{id}', [ProductController::class, 'show']);
    Route::match(['GET', 'POST'], 'delete-product/{id}', [ProductController::class, 'delete']);

    //Users
    Route::match(['GET', 'POST'], 'users', [UserController::class, 'index']);

});
