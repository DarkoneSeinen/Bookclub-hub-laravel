 <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            {{ __('Gestión de Órdenes') }}
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (session()->has('message'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Header con búsqueda y filtros -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="relative flex-1 max-w-md">
                        <input wire:model.live="search" type="text" placeholder="Buscar por # orden, cliente o email..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="flex gap-2">
                        <select wire:model.live="statusFilter" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Todos los estados</option>
                            @foreach($statuses as $key => $status)
                                <option value="{{ $key }}">{{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabla de órdenes -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"># Orden</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono font-medium text-indigo-600 dark:text-indigo-400">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name ?? 'Usuario eliminado' }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user->email ?? '-' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                    ${{ number_format($order->total_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" 
                                        class="text-xs rounded-full px-3 py-1 font-medium border-0 focus:ring-2 focus:ring-offset-2
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400' : '' }}">
                                        @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $status['label'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="viewOrder({{ $order->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Ver detalles
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500 dark:text-gray-400">No se encontraron órdenes</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    @if($showDetailModal && $selectedOrder)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Orden #{{ $selectedOrder->order_number }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $selectedOrder->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $selectedOrder->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $selectedOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $selectedOrder->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $selectedOrder->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($selectedOrder->status) }}
                        </span>
                    </div>

                    <!-- Info del cliente -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Información del Cliente</h4>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $selectedOrder->user->name ?? 'Usuario eliminado' }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $selectedOrder->user->email ?? '-' }}</p>
                    </div>

                    <!-- Items de la orden -->
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Productos</h4>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Libro</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Cant.</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Precio</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($selectedOrderItems as $item)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['book_title'] }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item['book_author'] }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-center text-sm text-gray-900 dark:text-white">{{ $item['quantity'] }}</td>
                                            <td class="px-4 py-3 text-right text-sm text-gray-900 dark:text-white">${{ number_format($item['unit_price'], 2) }}</td>
                                            <td class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">${{ number_format($item['subtotal'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">Total:</td>
                                        <td class="px-4 py-3 text-right text-lg font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($selectedOrder->total_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeModal" class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:w-auto sm:text-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
