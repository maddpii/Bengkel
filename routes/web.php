<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingAdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CashierTransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MechanicBookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceReviewAdminController;
use App\Http\Controllers\SparepartAdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleAdminController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/verify-otp', [AuthController::class, 'showOtpVerification'])->name('verification.otp.notice');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verification.otp.verify');
Route::post('/verify-otp/resend', [AuthController::class, 'resendOtp'])->name('verification.otp.resend');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.reports.index'),
        'mekanik' => redirect()->route('mechanic.bookings.index'),
        'kasir' => redirect()->route('cashier.transactions.index'),
        'owner' => redirect()->route('owner.reports.index'),
        default => redirect()->route('home'),
    };
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('vehicles', VehicleController::class)->only(['index', 'show']);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');
    Route::post('/transactions/{transaction}/review', [TransactionController::class, 'storeReview'])->name('transactions.review.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/payments/{transaction}/snap', [PaymentController::class, 'snap'])->name('payments.snap');
    Route::post('/payments/{transaction}/midtrans-result', [PaymentController::class, 'handleSnapResult'])->name('payments.result');
    Route::post('/payments/{transaction}/refresh-status', [PaymentController::class, 'refreshStatus'])->name('payments.refresh');
});

Route::post('/payments/midtrans/notification', [PaymentController::class, 'notification'])->name('payments.notification');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/konten-situs', [AdminController::class, 'editSiteContent'])->name('site-content.edit');
    Route::put('/konten-situs', [AdminController::class, 'updateSiteContent'])->name('site-content.update');
    Route::get('/bookings', [BookingAdminController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}/confirm', [AdminController::class, 'confirm'])->name('bookings.confirm');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::resource('/vehicles', VehicleAdminController::class)->except(['show']);
    Route::resource('/spareparts', SparepartAdminController::class)->except(['show']);
    Route::get('/reviews', [ServiceReviewAdminController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ServiceReviewAdminController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
    Route::get('/transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');
});

Route::middleware(['auth', 'role:mekanik'])->prefix('mekanik')->name('mechanic.')->group(function () {
    Route::get('/bookings', [MechanicBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [MechanicBookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}', [MechanicBookingController::class, 'update'])->name('bookings.update');
    Route::get('/transactions/create/{id}', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');
    Route::post('/transactions/add-sparepart', [TransactionController::class, 'addSparepart'])->name('transactions.add-sparepart');
});

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('cashier.')->group(function () {
    Route::get('/transactions', [CashierTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [CashierTransactionController::class, 'show'])->name('transactions.show');
    Route::put('/transactions/{transaction}', [CashierTransactionController::class, 'update'])->name('transactions.update');
    Route::get('/transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');
});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');
});

Route::middleware(['auth', 'role:admin,owner'])->group(function () {
    Route::get('/staff/reports', [ReportController::class, 'index'])->name('staff.reports.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('services', ServiceController::class);
});
