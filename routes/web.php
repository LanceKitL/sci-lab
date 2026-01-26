<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/approval-pending', function () {
    return view('auth.approval-pending');
})->name('approval.notice');

// create a route with IP ADDRESS
Route::get('/ip-address', function () {
    $address = request()->ip();    
    return "http://$address/login";
})->name('ip.address');

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('admin.users.approve');
    Route::delete('/users/{id}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('admin.users.reject');
    Route::get('/users/history', [App\Http\Controllers\Admin\UserController::class, 'history'])->name('admin.users.history');
});

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
    
    Route::get('/about', function () {
        return view('about');
    })->middleware(['auth', 'verified'])->name('about');

    // equipment routes
    Route::get('/equipment/{id}', [EquipmentController::class, 'show'])->name('equipment.show');
    Route::get('/search', [App\Http\Controllers\EquipmentController::class, 'search'])->name('equipment.search');
    // Equipment Management Routes
    Route::get('/equipment/{id}/edit', [App\Http\Controllers\EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::put('/equipment/{id}', [App\Http\Controllers\EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/equipment/{id}', [App\Http\Controllers\EquipmentController::class, 'destroy'])->name('equipment.destroy');

    // Borrowing Routes
    Route::get('/records', [App\Http\Controllers\BorrowController::class, 'index'])->name('records.index');
    Route::post('/borrow', [App\Http\Controllers\BorrowController::class, 'store'])->name('borrow.store');

    // Admin Actions (Protected)
    Route::middleware(['can:admin'])->group(function () {
        Route::post('/borrow/{id}/approve', [App\Http\Controllers\BorrowController::class, 'approve'])->name('borrow.approve');
        Route::post('/borrow/{id}/reject', [App\Http\Controllers\BorrowController::class, 'reject'])->name('borrow.reject');
        Route::post('/borrow/{id}/return', [App\Http\Controllers\BorrowController::class, 'markAsReturned'])->name('borrow.return');
    });


    // Attendance / Logbook Routes
    Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');

    Route::get('/labs/{slug}', [LaboratoryController::class, 'show'])->name('laboratories.show');
    Route::post('/equipment', [LaboratoryController::class, 'store'])->name('equipment.store');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
