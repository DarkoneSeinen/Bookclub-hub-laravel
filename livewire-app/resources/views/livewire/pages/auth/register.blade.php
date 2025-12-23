<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false));
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                📚 <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Bookclub Hub</span>
            </h1>
            <p class="text-gray-300 text-lg">Join Our Community</p>
        </div>

        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8">
            <form wire:submit="register" class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-white mb-2">
                        Full Name
                    </label>
                    <input 
                        wire:model="name" 
                        id="name" 
                        type="text" 
                        name="name" 
                        required 
                        autofocus
                        autocomplete="name"
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="John Doe"
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

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
                        autocomplete="username"
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="you@example.com"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

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
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                        Confirm Password
                    </label>
                    <input 
                        wire:model="password_confirmation" 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="••••••••"
                    />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-400 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Register Button -->
                <button 
                    type="submit"
                    class="w-full py-3 px-4 rounded-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 active:scale-95 shadow-lg shadow-purple-500/30"
                >
                    Create Account
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
                <p class="text-gray-300">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300 font-semibold transition-colors">
                        Sign in
                    </a>
                </p>
                <p class="text-xs text-gray-400">
                    <a href="/" class="text-gray-400 hover:text-white transition-colors">← Back to home</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-400 text-sm mt-8">
            By registering, you agree to our <a href="#" class="text-purple-400 hover:text-purple-300">Terms</a> and 
            <a href="#" class="text-purple-400 hover:text-purple-300">Privacy Policy</a>
        </p>
    </div>
</div>
