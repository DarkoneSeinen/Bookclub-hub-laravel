<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Profile;
use App\Livewire\Password;
use App\Livewire\Appearance;
use App\Livewire\AdminDashboard;
use App\Livewire\Admin\BooksManager;
use App\Livewire\Admin\OrdersManager;
use App\Livewire\Clubs\ClubIndex;
use App\Livewire\Clubs\ClubCreate;
use App\Livewire\Clubs\ClubShow;
use App\Livewire\Clubs\ClubSettings;
use App\Livewire\Clubs\MembersList;
use App\Livewire\Clubs\ReadingForm;
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

// ======== RUTAS CLUBS ========
Route::middleware(['auth'])->prefix('clubs')->name('clubs.')->group(function () {
    Route::get('/', ClubIndex::class)->name('index');
    Route::get('/create', ClubCreate::class)->name('create');
    Route::get('/{club}', ClubShow::class)->name('show');
    Route::get('/{club}/settings', ClubSettings::class)->name('settings');
    Route::get('/{club}/members', MembersList::class)->name('members');
    Route::get('/{club}/readings/create', ReadingForm::class)->name('readings.create');
    Route::get('/{club}/readings/{reading}/edit', ReadingForm::class)->name('readings.edit');
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

// ======== RUTAS ADMIN ========
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/books', BooksManager::class)->name('books');
    Route::get('/orders', OrdersManager::class)->name('orders');
});

require __DIR__.'/auth.php';