<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Carrito
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            @if(empty($cartItems))
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-600 text-lg mb-4">Tu carrito está vacío</p>
                    <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        ← Volver al catálogo
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @foreach($cartItems as $item)
                                <div class="border-b p-4 flex gap-4">
                                    <!-- Portada -->
                                    <div class="w-24 h-32 flex-shrink-0">
                                        @if($item['book']->cover_image)
                                            <img src="{{ $item['book']->cover_image }}" alt="{{ $item['book']->title }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center rounded">
                                                <span class="text-white text-2xl">📖</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info del Libro -->
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-800 mb-2">{{ $item['book']->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-4">por {{ $item['book']->author }}</p>

                                        <!-- Precio y Cantidad -->
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-green-600">${{ number_format($item['price'], 2) }}</span>

                                            <form method="POST" action="{{ route('cart.update', $item['book']->id) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <label class="text-sm text-gray-700">Cantidad:</label>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="10" class="w-16 px-2 py-1 border border-gray-300 rounded">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Actualizar</button>
                                            </form>

                                            <!-- Remover -->
                                            <form method="POST" action="{{ route('cart.destroy', $item['book']->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">✖</button>
                                            </form>
                                        </div>

                                        <!-- Subtotal -->
                                        <p class="mt-2 text-sm text-gray-600">
                                            Subtotal: <span class="font-bold">${{ number_format($item['subtotal'], 2) }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Resumen</h3>

                            <div class="space-y-3 mb-6 pb-6 border-b">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-semibold">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Envío:</span>
                                    <span class="font-semibold">Gratis</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Impuestos:</span>
                                    <span class="font-semibold">${{ number_format($total * 0.10, 2) }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between text-lg font-bold text-gray-800 mb-6">
                                <span>Total:</span>
                                <span>${{ number_format($total * 1.10, 2) }}</span>
                            </div>

                            <!-- Botones -->
                            <a href="{{ route('receipt.pdf') }}" class="w-full block text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold mb-3">
                                💳 Pagar
                            </a>

                            <a href="{{ route('books.index') }}" class="block w-full text-center bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition font-semibold">
                                Seguir Comprando
                            </a>

                            <form method="POST" action="{{ route('cart.clear') }}" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-red-600 hover:text-red-800 text-sm font-semibold">
                                    🗑️ Vaciar Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
