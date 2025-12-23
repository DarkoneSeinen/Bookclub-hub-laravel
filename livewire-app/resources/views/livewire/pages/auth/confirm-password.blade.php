<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false));
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                📚 <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Bookclub Hub</span>
            </h1>
            <p class="text-gray-300 text-lg">Confirm Your Password</p>
        </div>

        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8">
            <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>

            <form wire:submit="confirmPassword" class="space-y-6">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-white mb-2">
                        Password
                    </label>
                    <input 
                        wire:model="password" 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-3 px-4 rounded-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 active:scale-95 shadow-lg shadow-purple-500/30"
                >
                    Confirm Password
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-white/10"></div>
                <span class="text-sm text-gray-400">or</span>
                <div class="flex-1 h-px bg-white/10"></div>
            </div>

            <!-- Links -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    <a href="/" class="text-gray-400 hover:text-white transition-colors">← Back to home</a>
                </p>
            </div>
        </div>
    </div>
</div>
