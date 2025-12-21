<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bookclub Hub - Plataforma de Clubs de Lectura</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white">
        <!-- Navigation -->
        <nav class="fixed w-full backdrop-blur-md bg-black/30 z-50 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"/>
                    </svg>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Bookclub Hub</span>
                </div>
                <div class="flex gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2 rounded-lg border border-purple-400 text-purple-300 hover:bg-purple-400/10 transition">
                                Iniciar Sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 transition">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="min-h-screen flex flex-col justify-center items-center px-6 pt-20">
            <!-- Gradient Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto text-center">
                <!-- Main Logo -->
                <div class="mb-8 inline-block p-4 rounded-full bg-white/5 border border-white/10 backdrop-blur">
                    <svg class="w-16 h-16 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"/>
                    </svg>
                </div>

                <!-- Headline -->
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 bg-clip-text text-transparent">Bookclub Hub</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-2xl mx-auto">
                    Conecta con lectores apasionados, forma clubs de lectura y descubre nuevos mundos a través de los libros
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-4 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition font-semibold text-lg">
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition font-semibold text-lg">
                                Iniciar Sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-8 py-4 rounded-lg border-2 border-purple-400 text-purple-300 hover:bg-purple-400/10 transition font-semibold text-lg">
                                    Crear Cuenta Gratis
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-3 gap-8 mt-20">
                    <!-- Feature 1 -->
                    <div class="p-6 rounded-lg bg-white/5 border border-white/10 backdrop-blur hover:border-purple-400/50 transition">
                        <div class="text-4xl mb-4">📚</div>
                        <h3 class="text-xl font-semibold mb-2">Clubs de Lectura</h3>
                        <p class="text-gray-400">Crea o únete a clubs para compartir experiencias de lectura con otros apasionados</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 rounded-lg bg-white/5 border border-white/10 backdrop-blur hover:border-pink-400/50 transition">
                        <div class="text-4xl mb-4">🗳️</div>
                        <h3 class="text-xl font-semibold mb-2">Votaciones</h3>
                        <p class="text-gray-400">Elige democráticamente el próximo libro a leer junto a tu club</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 rounded-lg bg-white/5 border border-white/10 backdrop-blur hover:border-purple-400/50 transition">
                        <div class="text-4xl mb-4">💬</div>
                        <h3 class="text-xl font-semibold mb-2">Discusiones</h3>
                        <p class="text-gray-400">Participa en discusiones detalladas sobre los libros que lees</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="p-6 rounded-lg bg-white/5 border border-white/10 backdrop-blur hover:border-pink-400/50 transition">
                        <div class="text-4xl mb-4">🛍️</div>
                        <h3 class="text-xl font-semibold mb-2">Tienda de Libros</h3>
                        <p class="text-gray-400">Explora y compra libros desde nuestra tienda integrada</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="p-6 rounded-lg bg-white/5 border border-white/10 backdrop-blur hover:border-purple-400/50 transition">
                        <div class="text-4xl mb-4">❤️</div>
                        <h3 class="text-xl font-semibold mb-2">Wishlist</h3>
                        <p class="text-gray-400">Guarda tus libros favoritos para comprar más tarde</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="p-6 rounded-lg bg-white/5 border border-white/10 backdrop-blur hover:border-pink-400/50 transition">
                        <div class="text-4xl mb-4">⭐</div>
                        <h3 class="text-xl font-semibold mb-2">Reseñas</h3>
                        <p class="text-gray-400">Comparte tus opiniones y lee lo que otros piensan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-purple-400 mb-2">{{ \App\Models\Club::count() }}+</div>
                <p class="text-gray-400">Clubs Activos</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-pink-400 mb-2">{{ \App\Models\User::count() }}+</div>
                <p class="text-gray-400">Miembros</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-400 mb-2">{{ \App\Models\Book::count() }}+</div>
                <p class="text-gray-400">Libros</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-pink-400 mb-2">{{ \App\Models\Order::count() }}+</div>
                <p class="text-gray-400">Compras</p>
            </div>
        </div>

        <!-- CTA Final Section -->
        <div class="relative z-10 max-w-4xl mx-auto px-6 py-20 text-center">
            <div class="bg-gradient-to-r from-purple-600/20 to-pink-600/20 border border-purple-400/30 rounded-lg p-12 backdrop-blur">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">¿Listo para Comenzar?</h2>
                <p class="text-gray-300 mb-8 text-lg">Únete a nuestra comunidad de lectores y disfruta de la experiencia de compartir libros</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition font-semibold">
                            Registrarse Ahora
                        </a>
                    @endif
                    <a href="{{ route('books.index') }}" class="px-8 py-3 rounded-lg border-2 border-purple-400 text-purple-300 hover:bg-purple-400/10 transition font-semibold">
                        Explorar Catálogo
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-white/10 mt-20">
            <div class="max-w-7xl mx-auto px-6 py-12 text-center text-gray-400">
                <p>© 2025 Bookclub Hub. Todos los derechos reservados.</p>
            </div>
        </footer>
    </body>
</html>
        
