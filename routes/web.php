<?php

use App\Http\Controllers\BarrageController;
use App\Http\Controllers\BranchCanalController;
use App\Http\Controllers\ChannelImportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DehController;
use App\Http\Controllers\DistributaryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LocationImportController;
use App\Http\Controllers\MainCanalController;
use App\Http\Controllers\MinorController;
use App\Http\Controllers\SubCanalController;
use App\Http\Controllers\WatercourseController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TalukaController;
use App\Http\Controllers\TehsilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // / USERS ROUTES
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/status/update', [UserController::class, 'status_update'])->name('user.status.update');

    // / ROLES ROUTES
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/givePermissions/{id}', [RoleController::class, 'givePermissions'])->name('role.permissions');
    Route::post('/applyPermissions', [RoleController::class, 'applyPermissions'])->name('role.applyPermissions');

    // / PERMISSIONS ROUTES
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::get('/permission/destroy/{id}', [PermissionsController::class, 'destroy'])->name('permission.destroy');
    Route::post('/permission/store', [PermissionsController::class, 'store'])->name('permission.store');

    // / Location hierarchy (District → Taluka → Tehsil → DEH)
    Route::get('districts/{district}/confirm-delete', [DistrictController::class, 'confirmDelete'])->name('districts.confirm-delete');
    Route::get('talukas/{taluka}/confirm-delete', [TalukaController::class, 'confirmDelete'])->name('talukas.confirm-delete');
    Route::get('tehsils/{tehsil}/confirm-delete', [TehsilController::class, 'confirmDelete'])->name('tehsils.confirm-delete');
    Route::get('dehs/{deh}/confirm-delete', [DehController::class, 'confirmDelete'])->name('dehs.confirm-delete');

    Route::resource('districts', DistrictController::class);
    Route::resource('talukas', TalukaController::class);
    Route::resource('tehsils', TehsilController::class);
    Route::resource('dehs', DehController::class);

    Route::get('cascade/talukas/{district}', [TalukaController::class, 'byDistrict'])->name('cascade.talukas');
    Route::get('cascade/tehsils/{taluka}', [TehsilController::class, 'byTaluka'])->name('cascade.tehsils');
    Route::get('cascade/dehs/{tehsil}', [DehController::class, 'byTehsil'])->name('cascade.dehs');

    Route::get('locations/import', [LocationImportController::class, 'index'])->name('locations.import');
    Route::post('locations/import', [LocationImportController::class, 'store'])->name('locations.import.store');
    Route::get('locations/import/template', [LocationImportController::class, 'template'])->name('locations.import.template');
});

require __DIR__.'/auth.php';
