<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Categoryy;
use App\Livewire\ThankYou;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pos\AccountController;
use App\Http\Controllers\Pos\BuyTransactionController;
use App\Http\Controllers\Pos\ExpenseController;
use App\Http\Controllers\Pos\FinancialOverviewController;
use App\Http\Controllers\Pos\InvestmentController;
use App\Http\Controllers\Pos\SellTransactionController;
use App\Http\Controllers\Pos\TransactionController;
use App\Http\Livewire\AddressForm;
use App\Livewire\Cart;
use App\Livewire\Category;
use App\Livewire\Home;
use App\Livewire\ProductDetail;

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

Route::get('/', Home::class)->name('home');
Route::get('/product/{productId}', ProductDetail::class)->name('product.detail');
Route::get('/category/{categoryId}', Categoryy::class)->name('category.show');
Route::get('/cart', Cart::class)->name('cart.index');
Route::get('/thank-you', ThankYou::class)->name('thank-you');




Route::get('/products', function () {
    return view('products');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/export-invoices', [InvoiceController::class, 'export'])->name('export.invoices');
    Route::get('/import-invoices', [InvoiceController::class, 'importForm'])->name('import.invoices.form');
    Route::post('/import-invoices', [InvoiceController::class, 'import'])->name('import.invoices');
    Route::get('/invoices/{invoice}/edit-status', [InvoiceController::class, 'editStatus'])->name('invoices.editStatus');
    Route::post('/invoices/{invoice}/update-status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');


    Route::resource('orders', OrderController::class);

    Route::resource('investments', InvestmentController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('accounts', AccountController::class);
    Route::post('/accounts/recharge', [AccountController::class, 'recharge'])
    ->name('accounts.recharge');
    Route::post('/accounts/{account}/save-balance', [AccountController::class, 'saveBalance'])->name('accounts.save-balance');


    Route::get('financial-overview', [FinancialOverviewController::class, 'index'])->name('financial-overview');
    Route::get('/financial-overview-filter', [FinancialOverviewController::class, 'indexWithFilter'])->name('financial-overview.index');

    // Routes for Buy Transactions
    Route::get('buy-transactions', [BuyTransactionController::class, 'index'])->name('buy-transactions.index');
    Route::get('buy-transactions/create', [BuyTransactionController::class, 'create'])->name('buy-transactions.create');
    Route::post('buy-transactions', [BuyTransactionController::class, 'store'])->name('buy-transactions.store');

    // Routes for Sell Transactions
    Route::get('sell-transactions', [SellTransactionController::class, 'index'])->name('sell-transactions.index');
    Route::get('sell-transactions/create', [SellTransactionController::class, 'create'])->name('sell-transactions.create');
    Route::post('sell-transactions', [SellTransactionController::class, 'store'])->name('sell-transactions.store');





});

require __DIR__.'/auth.php';
