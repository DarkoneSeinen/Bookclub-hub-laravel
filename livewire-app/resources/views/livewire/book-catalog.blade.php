<div class="space-y-6">
    <!-- Búsqueda y Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Búsqueda -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar libros:</label>
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="Título, autor, ISBN..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>

        <!-- Filtros en una fila -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Filtro por Precio -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Precio:</label>
                <select wire:model.live="priceRange" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Todos los precios</option>
                    <option value="cheap">Hasta $15</option>
                    <option value="medium">$15 - $30</option>
                    <option value="expensive">Más de $30</option>
                </select>
            </div>

            <!-- Filtro por Ordenamiento -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ordenar por:</label>
                <select wire:model.live="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="latest">Más Recientes</option>
                    <option value="rating">Mejor Rating</option>
                    <option value="price-asc">Precio: Menor a Mayor</option>
                    <option value="price-desc">Precio: Mayor a Menor</option>
                </select>
            </div>

            <!-- Botón Limpiar Filtros -->
            <div class="flex items-end">
                <button 
                    wire:click="clearFilters" 
                    class="w-full px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition"
                >
                    Limpiar Filtros
                </button>
            </div>
        </div>

        <!-- Géneros (checkboxes) -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Géneros:</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($this->availableGenres as $genre)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model.live="selectedGenres" 
                            value="{{ $genre }}"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                        />
                        <span class="text-sm text-gray-700">{{ $genre }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            @if($books->count())
                {{ $books->total() }} libros encontrados
            @else
                No se encontraron libros
            @endif
        </h3>

        <!-- Grid de libros -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                    <!-- Portada del libro -->
                    <div class="h-64 bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                <span class="text-white text-4xl">📖</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <!-- Título -->
                        <h4 class="font-bold text-gray-800 line-clamp-2 mb-2">{{ $book->title }}</h4>

                        <!-- Autor -->
                        <p class="text-sm text-gray-600 mb-3">por <strong>{{ $book->author }}</strong></p>

                        <!-- Géneros -->
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($book->genres as $genre)
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $genre }}</span>
                            @endforeach
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <span class="text-yellow-400">★</span>
                            <span class="text-sm text-gray-700 ml-1">
                                @if($book->review_count > 0)
                                    {{ number_format($book->rating_avg, 1) }}/5 ({{ $book->review_count }})
                                @else
                                    Sin reseñas
                                @endif
                            </span>
                        </div>

                        <!-- Precio y Stock -->
                        <div class="flex justify-between items-center mb-4 pb-4 border-b">
                            <div>
                                @if($book->inventory)
                                    <span class="text-2xl font-bold text-green-600">${{ number_format($book->getDiscountedPrice(), 2) }}</span>
                                    @if($book->inventory->discount_percentage > 0)
                                        <span class="text-sm text-red-600 line-through">${{ number_format($book->getOriginalPrice(), 2) }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-600">N/A</span>
                                @endif
                            </div>
                            <span class="text-xs font-semibold @if($book->isAvailable()) text-green-600 @else text-red-600 @endif">
                                @if($book->isAvailable())
                                    ✓ En stock
                                @else
                                    Agotado
                                @endif
                            </span>
                        </div>

                        <!-- Botón Ver Detalle -->
                        <a href="{{ route('books.show', $book) }}" class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                            Ver Detalle
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">No se encontraron libros que coincidan con tus búsqueda y filtros.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($books->hasPages())
            <div class="mt-8">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
