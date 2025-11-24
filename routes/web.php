<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [WalletController::class, 'index'])->name('dashboard');
// Registration page
Route::get('/register', [WalletController::class, 'register'])->name('register');
Route::post('/call', [WalletController::class, 'call'])->name('wallet.call');

// Admin - Users
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/', fn () => redirect()->route('admin.users.index'));
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/call', [AdminUserController::class, 'call'])->name('users.call');
    Route::post('/users/exec', [AdminUserController::class, 'exec'])->name('users.exec');
    Route::get('/tags', [AdminUserController::class, 'tags'])->name('tags');
    Route::get('/tag/{tag}', [AdminUserController::class, 'byTag'])->name('byTag');
    Route::post('/call', [AdminUserController::class, 'call'])->name('call');
});
