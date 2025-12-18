<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Nueva Discusión</h1>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                <input type="text" id="title" wire:model="title" placeholder="¿Sobre qué quieres discutir?" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea id="description" wire:model="description" rows="4" placeholder="Describe tu discusión..." 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Libro (opcional)</label>
                
                @if ($selectedBook ?? null)
                    <div class="mb-4 p-4 border border-gray-300 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if($selectedBook->cover_image)
                                <img src="{{ Storage::url($selectedBook->cover_image) }}" alt="{{ $selectedBook->title }}" class="w-12 h-16 object-cover rounded">
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
                        <input type="text" wire:model.live="search" placeholder="Buscar libro..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        
                        @if (!empty($searchResults))
                            <div class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                                @foreach ($searchResults as $book)
                                    <button type="button" wire:click="selectBook({{ $book['id'] }})" 
                                            class="w-full px-4 py-3 hover:bg-gray-100 transition flex items-center gap-3 border-b border-gray-200 last:border-b-0 text-left">
                                        @if($book['cover_image'] ?? null)
                                            <img src="{{ Storage::url($book['cover_image']) }}" alt="{{ $book['title'] }}" class="w-8 h-12 object-cover rounded">
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $book['title'] }}</p>
                                            <p class="text-sm text-gray-600">{{ $book['author'] }}</p>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Crear Discusión
                </button>
                <a href="{{ route('clubs.discussions.index', $club) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
