<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-8 text-white">
                    <h1 class="text-4xl font-bold mb-2">¡Bienvenido, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-blue-100">Explora tu biblioteca personal, únete a clubs de lectura y descubre nuevos libros</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Books Purchased -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">📚 Libros Comprados</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ Auth::user()->orders()->count() }}
                            </p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Clubs Joined -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">👥 Clubs Unidos</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ Auth::user()->clubs()->count() }}
                            </p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a3 3 0 015.856-1.487"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Items -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">❤️ Favoritos</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ Auth::user()->wishlists()->count() }}
                            </p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Discussions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">💬 Discusiones</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ Auth::user()->discussions()->count() }}
                            </p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">🎯 Acciones Rápidas</h3>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('books.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-blue-50 transition">
                            <span class="text-3xl mb-2">📖</span>
                            <span class="text-sm font-medium text-gray-700 text-center">Explorar Libros</span>
                        </a>
                        <a href="{{ route('clubs.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-green-50 transition">
                            <span class="text-3xl mb-2">👥</span>
                            <span class="text-sm font-medium text-gray-700 text-center">Ver Clubs</span>
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-red-50 transition">
                            <span class="text-3xl mb-2">❤️</span>
                            <span class="text-sm font-medium text-gray-700 text-center">Mis Favoritos</span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-yellow-50 transition">
                            <span class="text-3xl mb-2">🛒</span>
                            <span class="text-sm font-medium text-gray-700 text-center">Mi Carrito</span>
                        </a>
                        <a href="{{ route('settings.profile') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-purple-50 transition">
                            <span class="text-3xl mb-2">⚙️</span>
                            <span class="text-sm font-medium text-gray-700 text-center">Perfil</span>
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center p-4 rounded-lg hover:bg-indigo-50 transition">
                                <span class="text-3xl mb-2">🔑</span>
                                <span class="text-sm font-medium text-gray-700 text-center">Admin</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg shadow p-6 border border-amber-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Consejo del Día</h3>
                    <div class="space-y-3">
                        <p class="text-sm text-gray-700">
                            🎓 <strong>Únete a un Club:</strong> Conecta con otros lectores y comparte experiencias de lectura.
                        </p>
                        <p class="text-sm text-gray-700">
                            🗳️ <strong>Participa en Votaciones:</strong> Ayuda a tu club a elegir el próximo libro a leer.
                        </p>
                        <p class="text-sm text-gray-700">
                            💬 <strong>Comparte tu Opinión:</strong> Participa en discusiones y lee reseñas de otros.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Featured Section -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">🌟 Tus Clubs Activos</h3>
                </div>
                <div class="p-6">
                    @php
                        $clubs = Auth::user()->clubs()->limit(3)->get();
                    @endphp

                    @if($clubs->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($clubs as $club)
                                <a href="{{ route('clubs.show', $club) }}" class="group">
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 hover:shadow-lg transition">
                                        <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $club->name }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($club->description, 60) }}</p>
                                        <div class="mt-3 flex items-center justify-between text-xs">
                                            <span class="text-gray-500">👥 {{ $club->members()->count() }} miembros</span>
                                            @php
                                                $role = Auth::user()->clubs()->where('club_id', $club->id)->first()?->pivot?->role;
                                            @endphp
                                            @if($role)
                                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full">{{ ucfirst($role) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('clubs.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Ver todos los clubs →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 mb-4">Aún no te has unido a ningún club</p>
                            <a href="{{ route('clubs.index') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Explorar Clubs →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
