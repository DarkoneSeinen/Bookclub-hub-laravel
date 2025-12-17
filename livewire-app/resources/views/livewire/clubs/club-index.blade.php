<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Clubs de Lectura</h1>
        <a href="{{ route('clubs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Crear Club
        </a>
    </div>

    <div class="mb-6">
        <input type="text" wire:model.live="search" placeholder="Buscar clubs..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    @if($clubs->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">No se encontraron clubs</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($clubs as $club)
                <a href="{{ route('clubs.show', $club) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden group">
                    @if($club->cover_image)
                        <img src="{{ Storage::url($club->cover_image) }}" alt="{{ $club->name }}" class="w-full h-48 object-cover group-hover:opacity-75 transition">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.753 2 16.253S6.5 26.253 12 26.253s10-4.5 10-10V6.253m0 0c5.5.5 10 5 10 10.5s-4.5 10-10 10"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $club->name }}</h2>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $club->description ?? 'Sin descripción' }}</p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 10a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                                </svg>
                                {{ $club->members()->count() }} miembro(s)
                            </div>
                            @if($club->is_private)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Privado
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $clubs->links() }}
        </div>
    @endif
</div>
