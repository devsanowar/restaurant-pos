<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CostCategoryController;
use App\Http\Controllers\Admin\FieldOfCostController;

Route::get('/', [App\Http\Controllers\Admin\AdminLoginPageController::class, 'index'])->name('admin.login');



Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // Cost Category Management
    Route::controller(CostCategoryController::class)->prefix('cost-category')->name('cost-category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

        // Field of Cost Management
    Route::controller(FieldOfCostController::class)->prefix('field-of-cost')->name('field-of-cost.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        
    });

    // Cost Management
    Route::controller(CostController::class)->prefix('cost')->name('cost.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        
    });



});     



