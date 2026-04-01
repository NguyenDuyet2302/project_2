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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLoginPost'])->name('admin.login.post');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Room
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Payment Methods
    Route::get('/payment_methods', [PaymentMethodController::class, 'index'])->name('payment_methods.index');
    Route::get('/payment_methods/create', [PaymentMethodController::class, 'create'])->name('payment_methods.create');
    Route::post('/payment_methods', [PaymentMethodController::class, 'store'])->name('payment_methods.store');
    Route::get('/payment_methods/{payment_method}/edit', [PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
    Route::put('/payment_methods/{payment_method}', [PaymentMethodController::class, 'update'])->name('payment_methods.update');
    Route::delete('/payment_methods/{payment_method}', [PaymentMethodController::class, 'destroy'])->name('payment_methods.destroy');

    // Service
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Contracts
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    //Invoice Detail
    Route::get('invoice-details', [InvoiceDetailController::class, 'index'])->name('invoiceDetails.index');
    Route::get('invoice-details/create', [InvoiceDetailController::class, 'create'])->name('invoiceDetails.create');
    Route::post('invoice-details', [InvoiceDetailController::class, 'store'])->name('invoiceDetails.store');
    Route::get('invoice-details/{service_id}/{invoice_id}/edit', [InvoiceDetailController::class, 'edit'])->name('invoiceDetails.edit');
    Route::put('invoice-details/{service_id}/{invoice_id}', [InvoiceDetailController::class, 'update'])->name('invoiceDetails.update');
    Route::delete('invoice-details/{service_id}/{invoice_id}', [InvoiceDetailController::class, 'destroy'])->name('invoiceDetails.destroy');

    //Service_detail
    Route::get('service-details', [ServiceDetailController::class, 'index'])->name('serviceDetails.index');
    Route::get('service-details/create', [ServiceDetailController::class, 'create'])->name('serviceDetails.create');
    Route::post('service-details', [ServiceDetailController::class, 'store'])->name('serviceDetails.store');
    Route::get('service-details/{room_id}/{service_id}/edit', [ServiceDetailController::class, 'edit'])->name('serviceDetails.edit');
    Route::put('service-details/{room_id}/{service_id}', [ServiceDetailController::class, 'update'])->name('serviceDetails.update');
    Route::delete('service-details/{room_id}/{service_id}', [ServiceDetailController::class, 'destroy'])->name('serviceDetails.destroy');
});
