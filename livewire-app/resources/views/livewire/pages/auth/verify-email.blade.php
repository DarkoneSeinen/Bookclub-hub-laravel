<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                📚 <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Bookclub Hub</span>
            </h1>
            <p class="text-gray-300 text-lg">Verify Your Email</p>
        </div>

        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8">
            <!-- Success Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/50 text-green-300 text-sm flex items-start gap-3">
                    <span class="text-xl">✓</span>
                    <p>A verification link has been sent to your email address. Please check your inbox and click the link to verify your account.</p>
                </div>
            @endif

            <div class="space-y-4">
                <p class="text-gray-300 text-sm leading-relaxed">
                    Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you.
                </p>
                <p class="text-gray-400 text-sm">
                    If you didn't receive the email, we'll gladly send you another.
                </p>
            </div>

            <div class="mt-6 space-y-3">
                <button 
                    wire:click="sendVerification"
                    type="button"
                    class="w-full py-3 px-4 rounded-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 active:scale-95 shadow-lg shadow-purple-500/30"
                >
                    Resend Verification Email
                </button>

                <button 
                    wire:click="logout"
                    type="button"
                    class="w-full py-3 px-4 rounded-lg font-semibold text-white bg-white/10 border border-white/20 hover:bg-white/20 transition-all"
                >
                    Log Out
                </button>
            </div>

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
