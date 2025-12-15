<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        🛡️ {{ __('Admin Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Órdenes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Órdenes</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $this->totalOrders }}</p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ingresos Totales -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Ingresos Totales</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">${{ number_format($this->totalRevenue, 2) }}</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Usuarios -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Usuarios</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $this->totalUsers }}</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12v-2a9 9 0 00-12 0v2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Libros -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Libros</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $this->totalBooks }}</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25m20-11.197C21.5 6.253 17 10.998 17 17.25m-2.5-1.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Últimas Órdenes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Últimas Órdenes</h3>
                    @if(count($this->recentOrders) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">ID Orden</th>
                                        <th class="px-4 py-2 text-left">Cliente</th>
                                        <th class="px-4 py-2 text-left">Total</th>
                                        <th class="px-4 py-2 text-left">Estado</th>
                                        <th class="px-4 py-2 text-left">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($this->recentOrders as $order)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 font-medium">#{{ $order['order_number'] }}</td>
                                            <td class="px-4 py-2">{{ $order['customer'] }}</td>
                                            <td class="px-4 py-2">${{ number_format($order['total'], 2) }}</td>
                                            <td class="px-4 py-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                                    {{ $order['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                                    {{ ucfirst($order['status']) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-gray-500">{{ $order['created_at'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No hay órdenes aún.</p>
                    @endif
                </div>
            </div>

            <!-- Libros Más Vendidos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">⭐ Top 5 Libros Más Vendidos</h3>
                    @if(count($this->topBooks) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Título</th>
                                        <th class="px-4 py-2 text-left">Autor</th>
                                        <th class="px-4 py-2 text-left">Vendidos</th>
                                        <th class="px-4 py-2 text-left">Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($this->topBooks as $book)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-2 font-medium">{{ $book['title'] }}</td>
                                            <td class="px-4 py-2">{{ $book['author'] }}</td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                    {{ $book['sold'] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 font-semibold">${{ number_format($book['revenue'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No hay libros vendidos aún.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
