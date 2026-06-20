<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BookingOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Leader\LeaderDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserPaymentController;
use App\Http\Controllers\User\UserInvoiceController;
use App\Http\Controllers\User\UserProfileController;

// ====================================================
// RUTE PUBLIK (Bisa diakses siapa saja)
// ====================================================

// Halaman Utama & Statis
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/leader', [LeaderController::class, 'index'])->name('leader.index');

// Halaman Etalase Paket
Route::get('/packages', [HomeController::class, 'packages'])->name('packages.index');
Route::get('/paket/{slug}', [HomeController::class, 'showPackage'])->name('package.show');

// Proses Booking (Form Sederhana & Redirect WA)
Route::get('/paket/{slug}/book', [BookingController::class, 'simpleForm'])->name('booking.simple');
Route::post('/paket/{slug}/book', [BookingController::class, 'storeSimple'])
    ->name('booking.storeSimple')
    ->middleware('throttle:5,60'); // Batasi spam (5x per menit)
Route::get('/booking/success/{id}', [BookingController::class, 'waRedirect'])->name('booking.waRedirect');


// ====================================================
// RUTE OTENTIKASI (Login & Register)
// ====================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('referral');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ====================================================
// RUTE ADMIN (Wajib Login)
// ====================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 1. Kelola Paket (Resource lengkap: index, create, store, edit, update, destroy)
    Route::resource('packages', PackageController::class)->names('admin.packages');

    // 2. Kelola Hotel
    Route::resource('hotels', HotelController::class)
        ->names('admin.hotels')
        ->except(['show']); // Hotel biasanya tidak butuh halaman detail (show)

    // 3. Kelola Destinasi (YANG TADINYA KAMU CARI)
    Route::resource('destinations', DestinationController::class)->names('admin.destinations');

    // 4. Kelola Galeri (INI YANG BARU DITAMBAHKAN)
    Route::resource('galleries', GalleryController::class)->names('admin.galleries');

    // 5. Kelola Pesanan / Booking & Keuangan
    Route::get('/bookings', [BookingOrderController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{id}/detail', [BookingOrderController::class, 'show'])->name('admin.bookings.show');
    Route::post('/bookings/{id}/status', [BookingOrderController::class, 'updateStatus'])->name('admin.bookings.update_status');
    Route::post('/bookings/{id}/payments', [BookingOrderController::class, 'storePayment'])->name('admin.bookings.store_payment');

    // 5b. Riwayat Semua Pembayaran
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
    Route::get('/payments/{id}/edit', [PaymentController::class, 'edit'])->name('admin.payments.edit');
    Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('admin.payments.update');
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::post('/payments/{id}/status', [PaymentController::class, 'updateStatus'])->name('admin.payments.updateStatus');
    Route::get('/payments/export', [PaymentController::class, 'export'])->name('admin.payments.export');
    Route::get('/payments/export/pdf', [PaymentController::class, 'exportPdf'])->name('admin.payments.export_pdf');

    // 5c. Invoice Dashboard
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('admin.invoice.create');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('admin.invoice.store');
    Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('admin.invoice.edit');
    Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('admin.invoice.update');
    Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('admin.invoice.destroy');
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice.index');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('admin.invoice.show');
    Route::get('/invoice/{id}/print', [InvoiceController::class, 'print'])->name('admin.invoice.print');
    Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])->name('admin.invoice.download');

    // 6. Kelola Leads / Inquiry (Prospek Masuk)
    Route::get('/inquiries', [\App\Http\Controllers\Admin\DashboardController::class, 'inquiries'])->name('admin.inquiries.index'); // Opsional jika dipisah
    Route::post('/inquiries/{id}/status', [\App\Http\Controllers\Admin\DashboardController::class, 'updateInquiryStatus'])->name('admin.inquiry.update_status');
    Route::get('/inquiries/{id}/convert', [\App\Http\Controllers\Admin\DashboardController::class, 'convertToBooking'])->name('admin.inquiry.convert');
    Route::post('/inquiries/{id}/convert', [\App\Http\Controllers\Admin\DashboardController::class, 'processConversion'])->name('admin.inquiry.process_convert');

    // 7. Akses Dashboard User (Impersonasi)
    Route::post('/user-access', [DashboardController::class, 'accessUserDashboard'])->name('admin.user.access');
    Route::get('/stop-impersonating', [DashboardController::class, 'stopImpersonating'])->name('admin.stop.impersonating');

});


// ====================================================
// RUTE LEADER (Wajib Login dengan Role Leader)
// ====================================================
Route::middleware(['auth', 'leader'])->prefix('leader')->group(function () {

    // Dashboard Utama Leader
    Route::get('/dashboard', [LeaderDashboardController::class, 'index'])->name('leader.dashboard');

    // Halaman Leader dengan struktur fungsi/index + fungsi/manage dll
    Route::get('/members', [LeaderDashboardController::class, 'members'])->name('leader.members.index');
    Route::get('/members/manage', [LeaderDashboardController::class, 'membersManage'])->name('leader.members.manage');
    Route::get('/reports', [LeaderDashboardController::class, 'reports'])->name('leader.reports.index');
    Route::get('/reports/analytics', [LeaderDashboardController::class, 'reportsAnalytics'])->name('leader.reports.analytics');
    Route::get('/reports/export', [LeaderDashboardController::class, 'reportsExport'])->name('leader.reports.export');

    // Generate ulang kode referral
    Route::post('/referral/regenerate', [LeaderDashboardController::class, 'regenerateReferral'])->name('leader.referral.regenerate');

    // Profil Leader (menggunakan layout leader, bukan user)
    Route::get('/profile', [LeaderDashboardController::class, 'profile'])->name('leader.profile');

    // Invoice Downline
    Route::get('/invoices', [LeaderDashboardController::class, 'invoices'])->name('leader.invoices.index');


});

// ====================================================
// RUTE USER / CUSTOMER DASHBOARD (Wajib Login)
// ====================================================
Route::middleware(['auth', \App\Http\Middleware\CheckImpersonation::class])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/payment', [UserPaymentController::class, 'index'])->name('payment');
    Route::post('/payment', [UserPaymentController::class, 'store'])->name('payment.store');
    Route::get('/invoices', [UserInvoiceController::class, 'index'])->name('invoices');
    Route::get('/invoices/{id}/print', [UserInvoiceController::class, 'print'])->name('invoices.print');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
});