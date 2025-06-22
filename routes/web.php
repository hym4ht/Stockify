<?php

use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('example.content.authentication.sign-in');
})->name('login');

Route::name('practice.')->group(function () {
    Route::name('index-practice')->get('practice', function () {
        return view('pages.practice.index');
    });
    Route::name('first')->get('practice/1', function () {
        return view('pages.practice.1');
    });
    Route::name('second')->get('practice/2', function () {
        return view('pages.practice.2');
    });
});

Route::get('/register', function () {
    return view('example.content.authentication.sign-up');
})->name('register');

Route::get('/calendar', function () {
    return view('example.content.calendar.index');
})->name('calendar');
Route::post('/calendar', [CalendarController::class, 'calendar'])->name(name: 'calendar.post');

// Auth routes
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', function () {
    return view('example.content.authentication.sign-in');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('users', UserController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/export/csv', [UserController::class, 'exportCsv'])->name('users.export.csv');
    Route::get('users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    Route::resource('product_attributes', ProductAttributeController::class);
    Route::get('reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    Route::get('reports/transactions', [ReportController::class, 'transactionReport'])->name('reports.transactions');
    Route::get('reports/user-activity', [ReportController::class, 'userActivityReport'])->name('reports.user_activity');
    Route::get('settings', [SettingController::class, 'adminSettings'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Stock routes
    Route::get('stock/info', [StockController::class, 'info'])->name('stock.info');
    Route::get('stock/settings', [StockController::class, 'settings'])->name('stock.settings');
    Route::put('stock/settings', [StockController::class, 'updateSettings'])->name('stock.settings.update');
});
Route::middleware(['auth', 'role:Manajer Gudang'])->prefix('manager')->name('manager.')->group(function () {
    // Contoh rute untuk manager
    Route::get('/reports', [ReportController::class, 'managerStockReport'])->name('reports.index');
    Route::get('reports/stock', [ReportController::class, 'managerStockReport'])->name('reports.stock');
    Route::get('settings', [SettingController::class, 'managerSettings'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Product routes for manager
    Route::get('products', [App\Http\Controllers\ManagerProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [App\Http\Controllers\ManagerProductController::class, 'show'])->name('products.show');

    // Stok routes for manager gudang
    Route::get('stok/transaksi/masuk', [App\Http\Controllers\TransaksiController::class, 'opnameMasuk'])->name('stok.transaksi.masuk');
    Route::get('stok/transaksi/keluar', [App\Http\Controllers\TransaksiController::class, 'opnameKeluar'])->name('stok.transaksi.keluar');
    Route::get('stok/opname', [App\Http\Controllers\TransaksiController::class, 'opnameIndex'])->name('stok.opname.index');

    // Supplier list route for manager (read-only)
    Route::get('suppliers', [App\Http\Controllers\SupplierController::class, 'managerIndex'])->name('suppliers.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/stock/opname', [TransaksiController::class, 'opnameIndex'])->name('stock.opname.index');
    Route::get('/stock/opname/masuk', [TransaksiController::class, 'opnameMasuk'])->name('stock.opname.masuk');
    Route::get('/stock/opname/keluar', [TransaksiController::class, 'opnameKeluar'])->name('stock.opname.keluar');
    Route::post('/stock/opname/confirm/{id}', [TransaksiController::class, 'confirmOpname'])->name('stock.opname.confirm');
    Route::post('/stock/opname/bulk-confirm', [TransaksiController::class, 'bulkConfirmOpname'])->name('stock.opname.bulkConfirm');
    Route::get('/stock/opname/bulk-confirm', function () {
        return redirect()->route('stock.opname.index');
    });
    Route::get('/stock', [TransaksiController::class, 'index'])->name('stock.index');

    // Profile route for authenticated users
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Staff settings routes remain under 'staf' prefix and middleware
    Route::middleware(['role:Staff Gudang'])->prefix('staf')->name('staf.')->group(function () {
        Route::get('settings', [SettingController::class, 'staffSettings'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    });
});

Route::middleware(['auth'])->group(function () {
    // Chat routes accessible to all authenticated users
    Route::get('/chat/inbox', [ChatController::class, 'inbox'])->name('chat.inbox');
    Route::get('/chat/{userId}', [ChatController::class, 'chat'])->name('chat.chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // API route for user search
    Route::get('/chat/search-users', [ChatController::class, 'searchUsers'])->name('chat.searchUsers');
});
