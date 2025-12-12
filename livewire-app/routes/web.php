<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Profile;
use App\Livewire\Password;
use App\Livewire\Appearance;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome');

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