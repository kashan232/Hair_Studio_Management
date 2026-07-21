<?php

use App\Http\Controllers\ChairController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HairstylistPortalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Hairstylist web app — public booking (no login required)
Route::prefix('stylist')->name('stylist.')->group(function () {
    Route::get('/', [HairstylistPortalController::class, 'index'])->name('home');
    Route::get('/book', [HairstylistPortalController::class, 'booking'])->name('book');
    Route::post('/book/time', [HairstylistPortalController::class, 'selectTime'])->name('book.time');
    Route::post('/book/availability/confirm', [HairstylistPortalController::class, 'confirmAvailability'])->name('book.availability.confirm');
    Route::post('/book/details', [HairstylistPortalController::class, 'confirmDetails'])->name('book.details');
    Route::post('/book/payment/intent', [HairstylistPortalController::class, 'createPaymentIntent'])->name('book.payment.intent');
    Route::get('/book/payment/success', [HairstylistPortalController::class, 'paymentSuccess'])->name('book.payment.success');
    Route::post('/book/reset', [HairstylistPortalController::class, 'clearBooking'])->name('book.reset');
    
    // Packages (Listing Available to Guests)
    Route::get('/packages', [\App\Http\Controllers\UserPackageController::class, 'index'])->name('packages.index');

    // Auth Middleware for My Bookings and Package Purchasing
    Route::middleware('auth')->group(function () {
        Route::get('/packages/{package}/checkout', [\App\Http\Controllers\UserPackageController::class, 'checkout'])->name('packages.checkout');
        Route::post('/packages/{package}/intent', [\App\Http\Controllers\UserPackageController::class, 'intent'])->name('packages.intent');
        Route::get('/packages/{package}/success', [\App\Http\Controllers\UserPackageController::class, 'success'])->name('packages.success');

        Route::get('/my-bookings', [HairstylistPortalController::class, 'myBookings'])->name('my_bookings');
        Route::post('/my-bookings/{id}/cancel', [HairstylistPortalController::class, 'cancelBooking'])->name('cancel_booking');
        Route::get('/my-bookings/{id}/amend', [HairstylistPortalController::class, 'amendBooking'])->name('amend_booking');
    });
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

    // Packages Management Routes
    Route::resource('/packages', \App\Http\Controllers\PackageController::class)->names('admin.packages');

    // Advanced Reporting Route
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

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
    // Bookings Management CRUD Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/update-status/{id}', [BookingController::class, 'updateStatus'])->name('bookings.update_status');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'adminCancel'])->name('bookings.cancel');
    Route::post('/bookings/{id}/refund', [BookingController::class, 'adminRefund'])->name('bookings.refund');

    // Coupons Management CRUD Routes
    Route::get('/coupons', [\App\Http\Controllers\CouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons/store', [\App\Http\Controllers\CouponController::class, 'store'])->name('coupons.store');
    Route::post('/coupons/delete/{id}', [\App\Http\Controllers\CouponController::class, 'destroy'])->name('coupons.destroy');
});

// Stylist Public Payment Link for Approved Overnight Bookings
Route::get('/stylist/bookings/{id}/pay', [BookingController::class, 'payBalance'])->name('stylist.bookings.pay');
Route::post('/stylist/coupon/apply', [\App\Http\Controllers\CouponController::class, 'apply'])->name('stylist.coupon.apply');
Route::post('/stylist/bookings/{id}/pay/intent', [BookingController::class, 'processBalancePayment'])->name('stylist.bookings.pay.intent');
Route::get('/stylist/bookings/{id}/pay/success', [BookingController::class, 'balancePaymentSuccess'])->name('stylist.bookings.pay.success');

require __DIR__.'/auth.php';

Route::get('/test-multi', function () {
    session([
        'stylist_booking.start_time' => \Carbon\Carbon::today()->setHour(13)->format('Y-m-d H:i:s'),
        'stylist_booking.end_time' => \Carbon\Carbon::today()->setHour(15)->format('Y-m-d H:i:s'),
        'stylist_booking.availability' => [
            'status' => 'multi_chair',
            'chair_ids' => [1, 2],
            'schedule' => [1, 2],
        ],
        'stylist_booking.step' => 2
    ]);
    return redirect('/stylist/book?step=2');
});

