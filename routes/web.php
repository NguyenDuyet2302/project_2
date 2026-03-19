<?php

use Illuminate\Support\Facades\Route;

//User
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

//Room
Route::get('/rooms', [\App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [\App\Http\Controllers\RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [\App\Http\Controllers\RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}/edit', [\App\Http\Controllers\RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [\App\Http\Controllers\RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [\App\Http\Controllers\RoomController::class, 'destroy'])->name('rooms.destroy');

//Paymentmethods
Route::get('/payment_methods', [\App\Http\Controllers\PaymentMethodController::class, 'index'])->name('payment_methods.index');
Route::get('/payment_methods/create', [\App\Http\Controllers\PaymentMethodController::class, 'create'])->name('payment_methods.create');
Route::post('/payment_methods', [\App\Http\Controllers\PaymentMethodController::class, 'store'])->name('payment_methods.store');
Route::get('payment_methods/{payment_method}/edit', [\App\Http\Controllers\PaymentMethodController::class, 'edit'])->name('payment_methods.edit');
Route::put('payment_methods/{payment_method}', [\App\Http\Controllers\PaymentMethodController::class, 'update'])->name('payment_methods.update');
Route::delete('payment_methods/{payment_method}', [\App\Http\Controllers\PaymentMethodController::class, 'destroy'])->name('payment_methods.destroy');

//Service
Route::get('/services', [\App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/create', [\App\Http\Controllers\ServiceController::class, 'create'])->name('services.create');
Route::post('/services', [\App\Http\Controllers\ServiceController::class, 'store'])->name('services.store');
Route::get('/services/{service}/edit', [\App\Http\Controllers\ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/{service}', [\App\Http\Controllers\ServiceController::class, 'update'])->name('services.update');
Route::delete('services/{service}', [\App\Http\Controllers\ServiceController::class, 'destroy'])->name('services.destroy');

//Contact
Route::get('/contracts', [\App\Http\Controllers\ContractController::class, 'index'])->name('contracts.index');
Route::get('/contracts/create', [\App\Http\Controllers\ContractController::class, 'create'])->name('contracts.create');
Route::post('/contracts', [\App\Http\Controllers\ContractController::class, 'store'])->name('contracts.store');
Route::get('/contracts/{contract}/edit', [\App\Http\Controllers\ContractController::class, 'edit'])->name('contracts.edit');
Route::put('/contracts/{contract}', [\App\Http\Controllers\ContractController::class, 'update'])->name('contracts.update');
Route::delete('contracts/{contract}', [\App\Http\Controllers\ContractController::class, 'destroy'])->name('contracts.destroy');

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
