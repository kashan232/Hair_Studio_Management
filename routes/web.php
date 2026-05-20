<?php

use App\Http\Controllers\ChairController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HairstylistPortalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Hairstylist web app (no admin dashboard)
Route::middleware(['auth', 'hairstylist'])->prefix('stylist')->name('stylist.')->group(function () {
    Route::get('/', [HairstylistPortalController::class, 'index'])->name('home');
    Route::get('/book', [HairstylistPortalController::class, 'booking'])->name('book');
    Route::post('/book/chair', [HairstylistPortalController::class, 'selectChair'])->name('book.chair');
    Route::post('/book/reset', [HairstylistPortalController::class, 'clearBooking'])->name('book.reset');
});

Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management CRUD Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Chairs Management CRUD Routes
    Route::get('/chairs', [ChairController::class, 'index'])->name('chairs.index');
    Route::post('/chairs/store', [ChairController::class, 'store'])->name('chairs.store');
    Route::post('/chairs/update/{id}', [ChairController::class, 'update'])->name('chairs.update');
    Route::post('/chairs/delete/{id}', [ChairController::class, 'destroy'])->name('chairs.destroy');

    // Pricing & Slots Management Routes
    Route::get('/pricing', [\App\Http\Controllers\PricingController::class, 'index'])->name('pricing.index');
    Route::post('/pricing/store', [\App\Http\Controllers\PricingController::class, 'store'])->name('pricing.store');
    Route::post('/pricing/update/{id}', [\App\Http\Controllers\PricingController::class, 'update'])->name('pricing.update');
    Route::post('/pricing/delete/{id}', [\App\Http\Controllers\PricingController::class, 'destroy'])->name('pricing.destroy');

    // Roles Management CRUD Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::post('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
    // Dedicated Permissions Assign Routes
    Route::get('/roles/assign-permissions/{id}', [RoleController::class, 'assignPermissions'])->name('roles.assign');
    Route::post('/roles/assign-permissions/{id}', [RoleController::class, 'savePermissions'])->name('roles.assign.save');

    // Permissions Management CRUD Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::post('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

require __DIR__.'/auth.php';
