<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\WaiterController;
use App\Http\Controllers\Admin\ResTableController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SmsReportController;
use App\Http\Controllers\Admin\StockItemController;
use App\Http\Controllers\Admin\SmsSettingController;
use App\Http\Controllers\Admin\FieldOfCostController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\CostCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdvancePaymentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\IncomeCategoryController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\RestaurantBranchController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\PurchaseController;

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
        Route::post('/restore-data', 'restoreData')->name('restore-data');
        Route::delete('/permanantly-destroy-data/{id}', 'forceDelete')->name('forceDelete');
    });

    // Supplier Management
    Route::controller(SupplierController::class)->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/trashed-data', 'trashedData')->name('deleted-data');
        Route::post('/restore-data', 'restoreData')->name('restore-data');
        Route::delete('/permanantly-destroy-data/{id}', 'forceDelete')->name('forceDelete');
    });

    // Stock item Management
    Route::controller(StockItemController::class)->prefix('stock-item')->name('stock.item.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/trashed-data', 'trashedData')->name('deleted-data');
        Route::post('/restore-data', 'restoreData')->name('restore-data');
        Route::delete('/permanantly-destroy-data/{id}', 'forceDelete')->name('forceDelete');
    });


    // Purchase Management
    Route::controller(PurchaseController::class)->prefix('purchase')->name('purchase.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


    // Stock Management
    Route::controller(StockController::class)->prefix('stock')->name('stock.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::post('/', 'out')->name('out');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        // Route::get('/trashed-data', 'trashedData')->name('deleted-data');
        // Route::post('/restore-data', 'restoreData')->name('restore-data');
        // Route::delete('/permanantly-destroy-data/{id}', 'forceDelete')->name('forceDelete');
    });



    // Restaurant Table Management
    Route::controller(ResTableController::class)->prefix('res-table')->name('res-table.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::get('/get-waiter/{tableId}', [ResTableController::class, 'getWaiter'])->name('get.waiter');

    // Waiter Management
    Route::controller(WaiterController::class)->prefix('waiter')->name('waiter.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


    //Income category Management route
    Route::controller(IncomeCategoryController::class)->prefix('income-category')->name('income.category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


    //Income Management route
    Route::controller(IncomeController::class)->prefix('income')->name('income.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/trashed-data', 'trashedData')->name('deleted-data');
        Route::post('/restore-data', 'restoreData')->name('restore-data');
        Route::delete('/permanantly-destroy-data/{id}', 'forceDelete')->name('forceDelete');
    });


    //User Management route
    Route::controller(UserManagementController::class)->prefix('user-management')->name('user.management.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    //General settings Management route
    Route::controller(SettingsController::class)->prefix('setting')->name('setting.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/update', 'update')->name('update');
    });

    //Restaurant management route
    Route::controller(RestaurantBranchController::class)->prefix('restaurant-branch')->name('restaurant.branch.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    //Restaurant management route
    Route::controller(PayrollController::class)->prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


    //Attendance management route
    Route::controller(AttendanceController::class)->prefix('employe/attendance')->name('attendance.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::get('/{id}/show', 'show')->name('show');
        Route::put('/update/{id}', 'update')->name('update');
    });

     // Sallery route here
    Route::controller(SalaryController::class)->prefix('salary')->name('salary.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/filter', 'filter')->name('filter');
    });

    // Advacne payment route
    Route::controller(AdvancePaymentController::class)->prefix('advance/payment')->name('advance.payment.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::get('/{id}/show', 'show')->name('show');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    Route::get('/get-salary/{employee_id}', [AdvancePaymentController::class, 'getSalary']);

    Route::get('/advance-payments/filter', [AdvancePaymentController::class, 'filter'])->name('advance.payment.filter');



    // SMS Settings
    Route::get('sms-settings', [SmsSettingController::class, 'edit'])->name('sms-settings.edit');
    Route::put('sms-settings', [SmsSettingController::class, 'update'])->name('sms-settings.update');

    Route::get('/sms', [SmsController::class, 'index'])->name('sms.index');
    Route::post('/send-message', [SmsController::class, 'send'])->name('send.sms');
    Route::get('/custom-sms', [SmsController::class, 'customSms'])->name('custom.sms');

    // Sms Report
    Route::prefix('sms-report')->group(function () {
        Route::get('sms-report', [SmsReportController::class, 'index'])->name('sms-report.index');
        Route::delete('destroy/{id}', [SmsReportController::class, 'destroy'])->name('sms-report.destroy');
    });

    // Product Category
    Route::resource('product-category', ProductCategoryController::class);

    // Product
    Route::resource('product', ProductController::class);

    // Sales
    Route::resource('sales', SalesController::class);

    // Order
    Route::resource('orders', OrderController::class);

    // PDF view (inline preview)
    Route::get('orders/{order}/invoice', [OrderController::class, 'showInvoice'])->name('orders.showInvoice');

    // PDF download
    Route::get('orders/{order}/download', [OrderController::class, 'download'])->name('orders.download');

});
