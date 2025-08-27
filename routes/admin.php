<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Admin\AdminLoginPageController::class, 'index'])->name('admin.login');

// AdminDashboard route
Route::get('dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');


