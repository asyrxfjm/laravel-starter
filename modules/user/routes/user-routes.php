<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AdminController;
use Modules\User\Http\Controllers\StaffController;
use Modules\User\Http\Controllers\StudentController;
use Modules\User\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('users.admin.index');
    });
});
