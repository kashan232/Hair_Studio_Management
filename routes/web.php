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
use App\Http\Controllers\BeatController;



use App\Events\MessageSent;


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});




Route::middleware(['auth','role:super-admin|admin'])->group(function () {

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

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


    Route::resource('units', \App\Http\Controllers\UnitController::class);
    Route::resource('regions', \App\Http\Controllers\RegionController::class);
    Route::resource('circles', CircleController::class);
    Route::resource('irrigation_divisions', \App\Http\Controllers\IrrigationDivisionController::class);
    Route::resource('sub_divisions', SubDivisionController::class);
    Route::resource('beats', BeatController::class);

    // Revenue Administration Routes
    Route::resource('revenue_divisions', \App\Http\Controllers\RevenueDivisionController::class);
    Route::resource('districts', \App\Http\Controllers\DistrictController::class);
    Route::resource('talukas', \App\Http\Controllers\TalukaController::class);
    Route::resource('revenue_circles', \App\Http\Controllers\RevenueCircleController::class);
    Route::resource('tappas', \App\Http\Controllers\TappaController::class);
    Route::resource('dehs', \App\Http\Controllers\DehController::class);
    Route::resource('survey_numbers', \App\Http\Controllers\SurveyNumberController::class);

    // Irrigation Administration AJAX
    Route::get('get-regions/{unit_id}', [\App\Http\Controllers\RegionController::class, 'getRegions']);
    Route::get('get-circles/{region_id}', [\App\Http\Controllers\CircleController::class, 'getCircles']);
    Route::get('get-irrigation-divisions/{circle_id}', [\App\Http\Controllers\IrrigationDivisionController::class, 'getIrrigationDivisions']);
    Route::get('get-sub-divisions/{irrigation_division_id}', [SubDivisionController::class, 'getSubDivisions']);
    Route::get('get-beats/{sub_division_id}', [BeatController::class, 'getBeats']);

    // Revenue Administration AJAX
    Route::get('get-districts/{revenue_division_id}', [\App\Http\Controllers\DistrictController::class, 'getDistricts']);
    Route::get('get-talukas/{district_id}', [\App\Http\Controllers\TalukaController::class, 'getTalukas']);
    Route::get('get-revenue-circles/{taluka_id}', [\App\Http\Controllers\RevenueCircleController::class, 'getRevenueCircles']);
    Route::get('get-tappas/{revenue_circle_id}', [\App\Http\Controllers\TappaController::class, 'getTappas']);
    Route::get('get-dehs/{tappa_id}', [\App\Http\Controllers\DehController::class, 'getDehs']);
    Route::get('get-survey-numbers/{deh_id}', [\App\Http\Controllers\SurveyNumberController::class, 'getSurveyNumbers']);

});
require __DIR__.'/auth.php';
