<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth']], function(){
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'getDashboardPage'])->name('admin.dashboard');
    Route::get('/branches', [App\Http\Controllers\AdminController::class, 'getBranchPage'])->name('admin.branches');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'getUserPage'])->name('admin.users');
    Route::get('/categories', [App\Http\Controllers\AdminController::class, 'getCategoryPage'])->name('admin.categories');
    Route::get('/brands', [App\Http\Controllers\AdminController::class, 'getBrandPage'])->name('admin.brands');
    Route::get('/suppliers', [App\Http\Controllers\AdminController::class, 'getSupplierPage'])->name('admin.suppliers');
    Route::get('/products', [App\Http\Controllers\AdminController::class, 'getProductPage'])->name('admin.products');
    // Stocks
    Route::get('/stocks/list', [App\Http\Controllers\AdminController::class, 'getStockPage'])->name('admin.stocks');
    Route::get('/stocks/productin', [App\Http\Controllers\AdminController::class, 'getProductInPage'])->name('admin.stocks.productin');
});

Route::group(['prefix'=>'staff', 'middleware'=>['isStaff','auth']], function(){
    Route::get('/dashboard', [App\Http\Controllers\StaffController::class, 'getDashboardPage'])->name('staff.dashboard');
    // Route::get('/branches', [App\Http\Controllers\StaffController::class, 'getBranchPage'])->name('staff.branches');
    // Route::get('/users', [App\Http\Controllers\StaffController::class, 'getUserPage'])->name('staff.users');
    Route::get('/categories', [App\Http\Controllers\StaffController::class, 'getCategoryPage'])->name('staff.categories');
    Route::get('/brands', [App\Http\Controllers\StaffController::class, 'getBrandPage'])->name('staff.brands');
    Route::get('/suppliers', [App\Http\Controllers\StaffController::class, 'getSupplierPage'])->name('staff.suppliers');
    Route::get('/products', [App\Http\Controllers\StaffController::class, 'getProductPage'])->name('staff.products');
    // Stocks
    Route::get('/stocks/list', [App\Http\Controllers\StaffController::class, 'getStockPage'])->name('staff.stocks');
    Route::get('/stocks/productin', [App\Http\Controllers\StaffController::class, 'getProductInPage'])->name('staff.stocks.productin');
    Route::get('/stocks/productout', [App\Http\Controllers\StaffController::class, 'getProductOutPage'])->name('staff.stocks.productout');

    Route::get('/customers', [App\Http\Controllers\StaffController::class, 'getCustomerPage'])->name('staff.customers');
    Route::get('/employees', [App\Http\Controllers\StaffController::class, 'getEmployeePage'])->name('staff.employees');
    Route::get('/stock-return', [App\Http\Controllers\StaffController::class, 'getStockReturnPage'])->name('staff.stock.return');

});

