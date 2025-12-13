<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Favoritos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($wishlistItems->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-600 text-lg mb-4">No tienes libros en favoritos</p>
                    <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        ← Explorar catálogo
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $item)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                            <!-- Portada -->
                            <div class="h-64 bg-gray-200 flex items-center justify-center">
                                @if($item->book->cover_image)
                                    <img src="{{ $item->book->cover_image }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                        <span class="text-white text-4xl">📖</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <!-- Título -->
                                <h4 class="font-bold text-gray-800 line-clamp-2 mb-2">{{ $item->book->title }}</h4>

                                <!-- Autor -->
                                <p class="text-sm text-gray-600 mb-3">por <strong>{{ $item->book->author }}</strong></p>

                                <!-- Precio -->
                                <div class="mb-4">
                                    @if($item->book->inventory)
                                        <span class="text-xl font-bold text-green-600">${{ number_format($item->book->getDiscountedPrice(), 2) }}</span>
                                    @endif
                                </div>

                                <!-- Botones -->
                                <a href="{{ route('books.show', $item->book) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold mb-2">
                                    Ver Detalles
                                </a>

                                <form method="POST" action="{{ route('wishlist.destroy', $item->id) }}" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-red-600 hover:text-red-800 text-sm font-semibold">
                                        ❌ Remover
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
