<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Profile;
use App\Livewire\Password;
use App\Livewire\Appearance;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReceiptController;

Route::view('/', 'welcome');

// Catálogo de libros (público)
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Carrito (público)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Recibo en PDF (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/receipt/pdf', [ReceiptController::class, 'generatePDF'])->name('receipt.pdf');
    Route::get('/order/confirmation', [ReceiptController::class, 'confirmation'])->name('order.confirmation');
});

// Wishlist (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::delete('/cart/{book}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/cart/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::resource('articles', ArticleController::class);
    Route::resource('users', UserController::class)->except(['show','create','store']);
});

require __DIR__.'/auth.php';