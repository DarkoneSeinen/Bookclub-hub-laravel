<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            {{ __('Gestión de Libros') }}
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

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header con búsqueda y botón crear -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="relative flex-1 max-w-md">
                        <input wire:model.live="search" type="text" placeholder="Buscar por título, autor o ISBN..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button wire:click="openCreateModal" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Nuevo Libro
                    </button>
                </div>
            </div>

            <!-- Tabla de libros -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Géneros</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($books as $book)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-10">
                                            <img class="h-12 w-10 rounded object-cover" src="{{ $book->cover_image }}" alt="{{ $book->title }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($book->title, 30) }}</div>
                                            <div class="text-sm text-gray-500">{{ $book->published_year }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $book->author }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $book->isbn }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600">${{ number_format($book->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @if(is_array($book->genres))
                                            @foreach(array_slice($book->genres, 0, 2) as $genre)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $genre }}
                                                </span>
                                            @endforeach
                                            @if(count($book->genres) > 2)
                                                <span class="text-xs text-gray-500">+{{ count($book->genres) - 2 }}</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="openEditModal({{ $book->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Editar
                                    </button>
                                    <button wire:click="deleteBook({{ $book->id }})" wire:confirm="¿Estás seguro de eliminar este libro?" class="text-red-600 hover:text-red-900">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">No se encontraron libros</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $books->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Crear/Editar -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            {{ $editMode ? 'Editar Libro' : 'Nuevo Libro' }}
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Título -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                                <input wire:model="title" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Autor -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Autor *</label>
                                <input wire:model="author" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('author') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- ISBN -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ISBN *</label>
                                <input wire:model="isbn" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('isbn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Precio -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio *</label>
                                <input wire:model="price" type="number" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Páginas -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Páginas</label>
                                <input wire:model="pages" type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('pages') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Año de Publicación -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Año de Publicación</label>
                                <input wire:model="published_year" type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('published_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Géneros -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Géneros (separados por coma)</label>
                                <input wire:model="genres" type="text" placeholder="Ficción, Aventura, Drama" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('genres') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea wire:model="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900"></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Imagen de Portada -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen de Portada</label>
                                <input wire:model="newCoverImage" type="file" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 bg-white text-gray-900">
                                @error('newCoverImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                
                                @if($newCoverImage)
                                    <img src="{{ $newCoverImage->temporaryUrl() }}" class="mt-2 h-24 rounded">
                                @elseif($cover_image && $editMode)
                                    <img src="{{ $cover_image }}" class="mt-2 h-24 rounded">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $editMode ? 'Actualizar' : 'Crear' }}
                        </button>
                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
