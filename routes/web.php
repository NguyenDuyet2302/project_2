<?php

use Illuminate\Support\Facades\Route;

//User
Route::controller(\App\Http\Controllers\UserController::class)
    ->name('users.')
    ->prefix('/users')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
    });

//Room
Route::controller(\App\Http\Controllers\RoomController::class)
    ->name('rooms.')
    ->prefix('/rooms')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{room}/edit', 'edit')->name('edit');
        Route::put('/{room}', 'update')->name('update');
        Route::delete('/{room}', 'destroy')->name('destroy');
    });

//Paymentmethods
Route::controller(\App\Http\Controllers\PaymentMethodController::class)
    ->name('payment_methods.')
    ->prefix('/payment_methods')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{payment_method}/edit', 'edit')->name('edit');
        Route::put('/{payment_method}', 'update')->name('update');
        Route::delete('/{payment_method}', 'destroy')->name('destroy');
    });

//Service
Route::controller(\App\Http\Controllers\ServiceController::class)
    ->name('services.')
    ->prefix('/services')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{service}/edit', 'edit')->name('edit');
        Route::put('/{service}', 'update')->name('update');
        Route::delete('/{service}', 'destroy')->name('destroy');
    });

//Contact
Route::controller(\App\Http\Controllers\ContractController::class)
    ->name('contracts.')
    ->prefix('/contracts')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{contract}/edit', 'edit')->name('edit');
        Route::put('/{contract}', 'update')->name('update');
        Route::delete('/{contract}', 'destroy')->name('destroy');
    });

//Service Detail
Route::controller(\App\Http\Controllers\ServiceDetailController::class)
    ->name('serviceDetails.')
    ->prefix('/serviceDetails')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        Route::get('/{service_id}/{room_id}/edit', 'edit')->name('edit');
        Route::put('/{service_id}/{room_id}', 'update')->name('update');
        Route::delete('/{service_id}/{room_id}', 'destroy')->name('destroy');
    });

//Invoice
Route::controller(\App\Http\Controllers\InvoiceController::class)
    ->name('invoices.')
    ->prefix('/invoices')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{invoice}/edit', 'edit')->name('edit');
        Route::put('/{invoice}', 'update')->name('update');
        Route::delete('/{invoice}', 'destroy')->name('destroy');
});

//Payments
Route::controller(\App\Http\Controllers\PaymentController::class)
    ->name('payments.')
    ->prefix('/payments')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{payment}/edit', 'edit')->name('edit');
        Route::put('/{payment}', 'update')->name('update');
        Route::delete('/{payment}', 'destroy')->name('destroy');
    });

//Invoice Detail
Route::controller(\App\Http\Controllers\InvoiceDetailController::class)
    ->name('invoiceDetails.')
    ->prefix('/invoiceDetails')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{service_id}/{invoice_id}/edit', 'edit')->name('edit');
        Route::put('/{service_id}/{invoice_id}', 'update')->name('update');
        Route::delete('/{service_id}/{invoice_id}', 'destroy')->name('destroy');
    });
