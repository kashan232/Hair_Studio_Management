<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\SubDivisionController;



use App\Events\MessageSent;


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});




Route::middleware(['auth','role:super-admin|admin'])->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('dashboard');

    ///USERS ROUTES
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/status/update',[UserController::class,'status_update'])->name('user.status.update');


    ///ROLES ROUTES
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/givePermissions/{id}', [RoleController::class, 'givePermissions'])->name('role.permissions');
    Route::post('/applyPermissions', [RoleController::class, 'applyPermissions'])->name('role.applyPermissions');

    ///Permissions ROUTES
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::get('/permission/destroy/{id}', [PermissionsController::class, 'destroy'])->name('permission.destroy');
    Route::post('/permission/store', [PermissionsController::class, 'store'])->name('permission.store');


    Route::resource('zones', ZoneController::class);
    Route::resource('circles', CircleController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('sub_divisions', SubDivisionController::class);
    Route::get('get-circles/{zone_id}', [DivisionController::class, 'getCircles']);
    Route::get('get-divisions/{circle_id}', [SubDivisionController::class, 'getDivisions']);

});
require __DIR__.'/auth.php';
