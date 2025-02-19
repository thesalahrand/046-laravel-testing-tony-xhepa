<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'about';
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware(['auth', EnsureUserIsAdmin::class]);
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware(['auth', EnsureUserIsAdmin::class]);
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware(['auth', EnsureUserIsAdmin::class]);
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware(['auth', EnsureUserIsAdmin::class]);
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware(['auth', EnsureUserIsAdmin::class]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
