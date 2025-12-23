<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false));
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-6">
    <!-- Gradient Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    </div>

    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-block p-3 rounded-full bg-white/5 border border-white/10 backdrop-blur mb-4">
                <svg class="w-12 h-12 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Bookclub Hub</h1>
            <p class="text-gray-400">Bienvenido de vuelta</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form wire:submit="login" class="space-y-4">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-white mb-2">Correo Electrónico</label>
                <input 
                    wire:model="form.email" 
                    id="email" 
                    type="email" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="tu@email.com"
                    class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition"
                />
                @error('form.email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
                <input 
                    wire:model="form.password" 
                    id="password" 
                    type="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 outline-none transition"
                />
                @error('form.password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    wire:model="form.remember" 
                    id="remember" 
                    type="checkbox" 
                    class="w-4 h-4 rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 cursor-pointer"
                />
                <label for="remember" class="ms-2 text-sm text-gray-300 cursor-pointer">
                    Recuérdame
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full px-4 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold transition mt-6"
            >
                Iniciar Sesión
            </button>
        </form>

        <!-- Forgot Password & Register Links -->
        <div class="mt-6 pt-6 border-t border-white/10 space-y-3">
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-purple-300 transition">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <div class="text-center text-gray-400">
                ¿No tienes cuenta?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 transition font-medium">
                        Regístrate aquí
                    </a>
                @endif
            </div>
        </div>

        <!-- Back to Home -->
        <div class="mt-4 text-center">
            <a href="/" class="text-sm text-gray-400 hover:text-gray-300 transition">
                ← Volver al inicio
            </a>
        </div>
    </div>
</div>
