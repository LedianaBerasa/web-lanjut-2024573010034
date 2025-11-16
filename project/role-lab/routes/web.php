<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/login'); // supaya / langsung ke login
});

// Dashboard (HARUS ADA untuk Breeze)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('all');  // atau halaman default sesuai kebutuhan
    })->name('dashboard');
});

// Route Profile (HARUS ADA untuk Breeze)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk semua role
Route::middleware('auth')->group(function () {

    Route::get('/all', function () {
        return view('all');
    });

    Route::get('/admin', function () {
        return view('admin');
    })->middleware('role:admin');

    Route::get('/manager', function () {
        return view('manager');
    })->middleware('role:manager');

    Route::get('/user', function () {
        return view('user');
    })->middleware('role:user');
});

// Tambahkan auth routes Breeze/Fortify
require __DIR__.'/auth.php';
