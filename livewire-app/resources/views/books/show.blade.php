<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $book->title }}
            </h2>
            <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Volver al catálogo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Portada y Información Principal -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Portada -->
                        <div class="h-96 bg-gray-200 flex items-center justify-center">
                            @if($book->cover_image)
                                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                    <span class="text-white text-6xl">📖</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <!-- Precio -->
                            @if($book->inventory)
                                <div class="mb-4">
                                    <span class="text-4xl font-bold text-green-600">${{ number_format($book->getDiscountedPrice(), 2) }}</span>
                                    @if($book->inventory->discount_percentage > 0)
                                        <span class="text-lg text-red-600 line-through ml-2">${{ number_format($book->getOriginalPrice(), 2) }}</span>
                                        <span class="text-sm text-red-600 font-semibold ml-2">-{{ $book->inventory->discount_percentage }}%</span>
                                    @endif
                                </div>

                                <!-- Stock -->
                                <div class="mb-4">
                                    @if($book->isAvailable())
                                        <span class="text-green-600 font-semibold">✓ En stock ({{ $book->inventory->quantity_available }} disponibles)</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Agotado</span>
                                    @endif
                                </div>

                                <!-- Carrito -->
                                <livewire:cart-manager :book="$book" />

                                <!-- Wishlist -->
                                <livewire:wishlist-button :book="$book" />
                            @endif
                    </div>
                </div>

                <!-- Información del Libro -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Título y Autor -->
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-600 mb-4">por <strong>{{ $book->author }}</strong></p>

                        <!-- Rating y Reviews -->
                        <div class="flex items-center mb-6 pb-6 border-b">
                            <span class="text-2xl text-yellow-400">★</span>
                            <span class="text-lg ml-2">
                                @if($book->review_count > 0)
                                    <strong>{{ number_format($book->rating_avg, 1) }}/5</strong> 
                                    ({{ $book->review_count }} reseña{{ $book->review_count != 1 ? 's' : '' }})
                                @else
                                    <em class="text-gray-500">Sin reseñas aún</em>
                                @endif
                            </span>
                        </div>

                        <!-- Información Básica -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-gray-600 text-sm">Año de Publicación</p>
                                <p class="text-gray-800 font-semibold">{{ $book->published_year ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Páginas</p>
                                <p class="text-gray-800 font-semibold">{{ $book->pages ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">ISBN</p>
                                <p class="text-gray-800 font-semibold">{{ $book->isbn ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Formato</p>
                                <p class="text-gray-800 font-semibold">{{ $book->inventory?->format == 'physical' ? 'Tapa dura' : ($book->inventory?->format == 'digital' ? 'Digital' : 'Ambos') }}</p>
                            </div>
                        </div>

                        <!-- Géneros -->
                        <div class="mb-6">
                            <p class="text-gray-600 text-sm mb-2">Géneros</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($book->genres as $genre)
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">{{ $genre }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Descripción</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $book->description ?? 'No hay descripción disponible.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reseñas -->
            <div class="mt-12">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Reseñas ({{ $reviews->count() }})</h2>

                    <!-- Componente Livewire para formulario de reseña -->
                    <livewire:review-form :book="$book" />

                    <!-- Lista de Reseñas -->
                    <div class="space-y-6">
                        @forelse($reviews as $review)
                            <div class="border-b pb-6">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            <span class="text-yellow-400">★</span>
                                            {{ $review->rating }}/5 - {{ $review->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">{{ $review->helpful_count }} útil{{ $review->helpful_count != 1 ? 's' : '' }}</span>
                                </div>
                                @if($review->title)
                                    <h4 class="font-semibold text-gray-800 mb-2">{{ $review->title }}</h4>
                                @endif
                                <p class="text-gray-700">{{ $review->content }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">No hay reseñas aún. ¡Sé el primero en calificar este libro!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
