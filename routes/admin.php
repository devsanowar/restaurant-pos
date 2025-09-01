<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\SmsLogController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\FieldOfCostController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\CostCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SmsApiSettingsController;

Route::get('/', [App\Http\Controllers\Admin\AdminLoginPageController::class, 'index'])->name('admin.login');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    
    // Admin Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    //Admin Settings
    Route::controller(AdminSettingController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/change-password',  'changePassword')->name('password.change');
        Route::post('/image/update',  'updateImage')->name('image.update');
    });


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
        Route::get('/trashed-data', 'trashedData')->name('deleted-data');
        Route::delete('/permanantly-destroy-data/{id}', 'forceDeleteData')->name('destroy-data');
    });


    // Supplier Management
    Route::controller(SupplierController::class)->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


    // SMS Api Settings Management
    Route::controller(SmsApiSettingsController::class)->prefix('sms-api-settings')->name('sms-api.settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/update', 'update')->name('update');
    });

    // Sms Management
    Route::controller(SmsController::class)->prefix('sms')->group(function () {
        Route::get('/', 'index')->name('sms.index');
        Route::get('/custom', 'customeSms')->name('send.custom.sms');
        Route::post('/send-custom-sms/send', 'sendCustomSms')->name('send.custom.sms.send');
        Route::get('/sms-summary', 'getSmsSummary')->name('sms.summary');
    });

   
    



});     



