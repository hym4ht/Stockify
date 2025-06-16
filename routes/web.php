<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('products/import', [ProductController::class, 'importForm'])->name('products.import.form');
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('users', UserController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::resource('product_attributes', ProductAttributeController::class);
    Route::get('reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    Route::get('reports/transactions', [ReportController::class, 'transactionReport'])->name('reports.transactions');
    Route::get('reports/user-activity', [ReportController::class, 'userActivityReport'])->name('reports.user_activity');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

// Route for staf gudang to confirm stock transactions
Route::middleware(['auth'])->group(function () {
    // Route::post('/staf/confirm/{id}', [TransaksiController::class, 'confirmTransaction'])->name('staf.confirm');

    // Stock opname routes for staff gudang
    Route::get('/stock/opname', [TransaksiController::class, 'opnameIndex'])->name('stock.opname.index');
    Route::get('/stock/opname/masuk', [TransaksiController::class, 'opnameMasuk'])->name('stock.opname.masuk');
    // Route::get('/stock/opname/masuk/create', [TransaksiController::class, 'createOpnameMasuk'])->name('stock.opname.masuk.create');
    // Route::post('/stock/opname/masuk', [TransaksiController::class, 'storeOpnameMasuk'])->name('stock.opname.masuk.store');
    Route::get('/stock/opname/keluar', [TransaksiController::class, 'opnameKeluar'])->name('stock.opname.keluar');
    // Route::get('/stock/opname/keluar/create', [TransaksiController::class, 'createOpnameKeluar'])->name('stock.opname.keluar.create');
    // Route::post('/stock/opname/keluar', [TransaksiController::class, 'storeOpnameKeluar'])->name('stock.opname.keluar.store');
    Route::post('/stock/opname/confirm/{id}', [TransaksiController::class, 'confirmOpname'])->name('stock.opname.confirm');
    Route::post('/stock/opname/bulk-confirm', [TransaksiController::class, 'bulkConfirmOpname'])->name('stock.opname.bulkConfirm');
    Route::get('/stock/opname/bulk-confirm', function () {
        return redirect()->route('stock.opname.index');
    });
    Route::get('/stock', [TransaksiController::class, 'index'])->name('stock.index');

    // Chat routes
    Route::get('/chat/inbox', [ChatController::class, 'inbox'])->name('chat.inbox');
    Route::get('/chat/{userId}', [ChatController::class, 'chat'])->name('chat.chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // API route for user search
    Route::get('/chat/search-users', [ChatController::class, 'searchUsers'])->name('chat.searchUsers');
});
