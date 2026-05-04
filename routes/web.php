<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\CustomerController;
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/bcrypt', function () {
    return bcrypt('123456');
});

Route::get('/home', [CustomerController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

Route::middleware(['authAdmin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::get('/payment_methods', [PaymentMethodController::class, 'index'])->name('payment_methods.index');
    Route::get('/payment_methods/create', [PaymentMethodController::class, 'create'])->name('payment_methods.create');
    Route::post('/payment_methods', [PaymentMethodController::class, 'store'])->name('payment_methods.store');
    Route::get('/payment_methods/{payment_method}/edit', [PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
    Route::put('/payment_methods/{payment_method}', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
    Route::delete('/payment_methods/{payment_method}', [PaymentMethodController::class, 'destroy'])->name('payment_methods.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    Route::get('invoice-details', [InvoiceDetailController::class, 'index'])->name('invoiceDetails.index');
    Route::get('invoice-details/create', [InvoiceDetailController::class, 'create'])->name('invoiceDetails.create');
    Route::post('invoice-details', [InvoiceDetailController::class, 'store'])->name('invoiceDetails.store');
    Route::get('invoice-details/{service_id}/{invoice_id}/edit', [InvoiceDetailController::class, 'edit'])->name('invoiceDetails.edit');
    Route::put('invoice-details/{service_id}/{invoice_id}', [InvoiceDetailController::class, 'update'])->name('invoiceDetails.update');
    Route::delete('invoice-details/{service_id}/{invoice_id}', [InvoiceDetailController::class, 'destroy'])->name('invoiceDetails.destroy');

    Route::get('serviceDetails', [ServiceDetailController::class, 'index'])->name('serviceDetails.index');
    Route::get('serviceDetails/create', [ServiceDetailController::class, 'create'])->name('serviceDetails.create');
    Route::post('serviceDetails', [ServiceDetailController::class, 'store'])->name('serviceDetails.store');
    Route::get('serviceDetails/{room_id}/{service_id}/edit', [ServiceDetailController::class, 'edit'])->name('serviceDetails.edit');
    Route::put('serviceDetails/{room_id}/{service_id}', [ServiceDetailController::class, 'update'])->name('serviceDetails.update');
    Route::delete('serviceDetails/{room_id}/{service_id}', [ServiceDetailController::class, 'destroy'])->name('serviceDetails.destroy');


});

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/home', [CustomerController::class, 'dashboard'])->name('customer.home');

    // Thêm dòng này cho trang cá nhân của khách
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::put('/customer/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/customer/contract', [CustomerController::class, 'viewContract'])->name('customer.contract');
    Route::get('/customer/invoices', [CustomerController::class, 'viewInvoices'])->name('customer.invoices');
});
