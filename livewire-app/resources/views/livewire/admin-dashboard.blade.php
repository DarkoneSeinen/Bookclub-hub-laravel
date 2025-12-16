<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            {{ __('Panel de Administración') }}
        </h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ now()->format('d M, Y') }}
        </span>
    </div>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Grid de Estadísticas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Órdenes -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Órdenes</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalOrders) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ingresos Totales -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium uppercase tracking-wide">Ingresos</p>
                        <p class="text-4xl font-bold mt-2">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Usuarios -->
            <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-violet-100 text-sm font-medium uppercase tracking-wide">Usuarios</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalUsers) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Libros -->
            <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium uppercase tracking-wide">Libros</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalBooks) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de 2 columnas para tablas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Últimas Órdenes -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Últimas Órdenes
                    </h3>
                </div>
                <div class="p-6">
                    @if(count($recentOrders) > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">#{{ $order['id'] }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $order['customer'] }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order['created_at'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900 dark:text-white">${{ number_format($order['total'], 2) }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $order['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' : '' }}
                                            {{ $order['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400' : '' }}
                                            {{ $order['status'] === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400' : '' }}">
                                            {{ ucfirst($order['status']) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">No hay órdenes aún</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Top 5 Libros Más Vendidos -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        Top 5 Libros Más Vendidos
                    </h3>
                </div>
                <div class="p-6">
                    @if(count($topBooks) > 0)
                        <div class="space-y-4">
                            @foreach($topBooks as $index => $book)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white
                                            {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : '' }}
                                            {{ $index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : '' }}
                                            {{ $index === 2 ? 'bg-gradient-to-br from-amber-600 to-amber-800' : '' }}
                                            {{ $index > 2 ? 'bg-gray-400 dark:bg-gray-600' : '' }}">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white line-clamp-1">{{ $book['title'] }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book['author'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($book['revenue'], 2) }}</p>
                                        <span class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            {{ $book['sold'] }} vendidos
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">No hay ventas aún</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('admin.books') }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-600 transition-all group">
                <div class="flex items-center gap-4">
                    <div class="bg-amber-100 dark:bg-amber-900/50 p-3 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Gestionar Libros</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Crear, editar y eliminar libros del catálogo</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 ml-auto group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.orders') }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-600 transition-all group">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Gestionar Órdenes</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ver detalles y actualizar estados de órdenes</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 ml-auto group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        </div>

    </div>
</div>
