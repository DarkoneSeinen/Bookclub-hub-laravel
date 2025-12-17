<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Crear Nuevo Club</h1>

        <form wire:submit="save" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Club *</label>
                <input type="text" id="name" wire:model="name" placeholder="Ej: Club de Ciencia Ficción" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea id="description" wire:model="description" rows="4" placeholder="Describe tu club..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="max_members" class="block text-sm font-medium text-gray-700 mb-1">Límite de Miembros</label>
                    <input type="number" id="max_members" wire:model="max_members" placeholder="Dejar vacío para ilimitado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('max_members') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-end">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_private" class="w-4 h-4 border-gray-300 rounded">
                        <span class="ml-2 text-sm font-medium text-gray-700">Hacer Privado</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Imagen de Portada</label>
                <input type="file" id="cover_image" wire:model="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('cover_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if($cover_image)
                    <div class="mt-4">
                        <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview" class="w-32 h-40 object-cover rounded">
                    </div>
                @endif
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Crear Club
                </button>
                <a href="{{ route('clubs.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
