<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            {{ $reading ? 'Editar Lectura' : 'Nueva Lectura' }}
        </h1>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <!-- Búsqueda de Libros -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Libro</label>
                
                @if ($selectedBook)
                    <div class="mb-4 p-4 border border-gray-300 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if($selectedBook->cover_image)
                                <img src="{{ Storage::url($selectedBook->cover_image) }}" alt="{{ $selectedBook->title }}" class="w-12 h-16 object-cover rounded">
                            @else
                                <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.753 2 16.253S6.5 26.253 12 26.253s10-4.5 10-10V6.253m0 0c5.5.5 10 5 10 10.5s-4.5 10-10 10"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $selectedBook->title }}</p>
                                <p class="text-sm text-gray-600">{{ $selectedBook->author }}</p>
                            </div>
                        </div>
                        <button type="button" wire:click="$set('book_id', null)" class="text-red-600 hover:text-red-700">Cambiar</button>
                    </div>
                @else
                    <div class="relative">
                        <input type="text" id="search" wire:model.live="search" placeholder="Buscar libro por título o autor..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        
                        @if (!empty($searchResults))
                            <div class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                                @foreach ($searchResults as $book)
                                    <button type="button" wire:click="selectBook({{ $book['id'] }})" 
                                            class="w-full px-4 py-3 hover:bg-gray-100 transition flex items-center gap-3 border-b border-gray-200 last:border-b-0">
                                        @if($book['cover_image'] ?? null)
                                            <img src="{{ Storage::url($book['cover_image']) }}" alt="{{ $book['title'] }}" class="w-8 h-12 object-cover rounded">
                                        @else
                                            <div class="w-8 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="text-left">
                                            <p class="font-medium text-gray-900">{{ $book['title'] }}</p>
                                            <p class="text-sm text-gray-600">{{ $book['author'] }}</p>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @error('book_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @endif
            </div>

            <!-- Estado -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="status" wire:model="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="planeado">Planeado</option>
                    <option value="en_curso">En Curso</option>
                    <option value="completado">Completado</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                    <input type="date" id="start_date" wire:model="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Fin</label>
                    <input type="date" id="end_date" wire:model="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    {{ $reading ? 'Actualizar' : 'Crear' }} Lectura
                </button>
                <a href="{{ route('clubs.show', $club) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
