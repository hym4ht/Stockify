<?php
use App\Http\Controllers\Admin\StockOpnameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAttributeController;

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

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('products/import', [ProductController::class, 'importForm'])->name('products.import.form');
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('stock', StockController::class)->only(['index', 'create', 'store']);
    Route::resource('users', UserController::class);
    Route::resource('product_attributes', ProductAttributeController::class);
    Route::get('reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    Route::get('reports/transactions', [ReportController::class, 'transactionReport'])->name('reports.transactions');
    Route::get('reports/user-activity', [ReportController::class, 'userActivityReport'])->name('reports.user_activity');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('stock-opname', StockOpnameController::class);
});
