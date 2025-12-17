<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Configuración del Club</h1>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="update" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Club</label>
                <input type="text" id="name" wire:model="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea id="description" wire:model="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="max_members" class="block text-sm font-medium text-gray-700 mb-1">Límite de Miembros</label>
                    <input type="number" id="max_members" wire:model="max_members" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('max_members') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-end">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_private" class="w-4 h-4 border-gray-300 rounded">
                        <span class="ml-2 text-sm font-medium text-gray-700">Hacer Privado</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
                <a href="{{ route('clubs.show', $club) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="button" wire:click="$set('showDeleteModal', true)" class="ml-auto px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Eliminar Club
                </button>
            </div>
        </form>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Eliminar Club</h2>
                <p class="text-gray-600 mb-6">
                    ¿Estás seguro de que quieres eliminar <strong>{{ $club->name }}</strong>? 
                    Esta acción no se puede deshacer.
                </p>
                <div class="flex gap-4">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button wire:click="deleteClub" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
