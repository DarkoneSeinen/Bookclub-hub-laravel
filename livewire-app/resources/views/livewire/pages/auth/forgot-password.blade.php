<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                📚 <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Bookclub Hub</span>
            </h1>
            <p class="text-gray-300 text-lg">Reset Your Password</p>
        </div>

        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/50 text-green-300 text-sm">
                    ✓ {{ session('status') }}
                </div>
            @endif

            <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                Forgot your password? No problem. Just enter your email address and we'll send you a password reset link.
            </p>

            <form wire:submit="sendPasswordResetLink" class="space-y-6">
                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                        Email Address
                    </label>
                    <input 
                        wire:model="email" 
                        id="email" 
                        type="email" 
                        name="email" 
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="you@example.com"
                    />
                    @error('email')
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
                    Send Reset Link
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-white/10"></div>
                <span class="text-sm text-gray-400">or</span>
                <div class="flex-1 h-px bg-white/10"></div>
            </div>

            <!-- Links -->
            <div class="mt-6 text-center space-y-3">
                <p class="text-gray-300 text-sm">
                    <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-semibold transition-colors">
                        Back to Login
                    </a>
                </p>
                <p class="text-xs text-gray-400">
                    <a href="/" class="text-gray-400 hover:text-white transition-colors">← Back to home</a>
                </p>
            </div>
        </div>
    </div>
</div>
