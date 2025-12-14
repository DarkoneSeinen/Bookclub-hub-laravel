<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✅ Compra Confirmada
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Confirmación -->
            <div class="bg-white shadow-md rounded-lg p-8 text-center mb-8">
                <div class="text-6xl mb-4">✅</div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">¡Compra Confirmada!</h1>
                <p class="text-gray-600 mb-4">Tu PDF ha sido descargado</p>
                <p class="text-2xl font-bold text-green-600">{{ $order->order_number }}</p>
            </div>

            <!-- Detalles de la Orden -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles de tu Orden</h3>

                <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b">
                    <div>
                        <p class="text-sm text-gray-600">Número de Orden</p>
                        <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Fecha</p>
                        <p class="font-semibold text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Estado</p>
                        <p class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-sm">
                            Pendiente de Pago
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="font-bold text-green-600 text-lg">${{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>

                <!-- Items Comprados -->
                <h4 class="font-semibold text-gray-900 mb-4">Libros Comprados</h4>
                <div class="space-y-4 mb-6 pb-6 border-b">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start bg-gray-50 p-4 rounded">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->book->title }}</p>
                                <p class="text-sm text-gray-600">por {{ $item->book->author }}</p>
                                <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                            </div>
                            <p class="font-semibold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Resumen de Precio -->
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->total_price * 0.926, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Impuesto (8%):</span>
                        <span>${{ number_format($order->total_price * 0.074, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-4 border-t">
                        <span>Total:</span>
                        <span class="text-green-600">${{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Siguiente Paso -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">📋 Próximos Pasos</h3>
                <ul class="space-y-2 text-blue-900">
                    <li>✅ PDF de recibo descargado</li>
                    <li>✅ Orden registrada en el sistema</li>
                    <li>⏳ Estado: Pendiente de Pago</li>
                    <li>📧 Verifica tu email para más detalles</li>
                </ul>
            </div>

            <!-- Botones de Acción -->
            <div class="flex gap-4">
                <a href="{{ route('books.index') }}" class="flex-1 text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    📚 Seguir Comprando
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 text-center bg-gray-200 text-gray-800 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
                    👤 Mi Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
