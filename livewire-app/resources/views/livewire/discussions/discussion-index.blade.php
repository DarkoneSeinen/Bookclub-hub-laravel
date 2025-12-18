<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Discusiones</h1>
                <p class="text-gray-600">{{ $club->name }}</p>
            </div>
            @auth
                <a href="{{ route('clubs.discussions.create', $club) }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Nueva Discusión
                </a>
            @endauth
        </div>

        <!-- Búsqueda y Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <input type="text" wire:model.live="search" placeholder="Buscar discusiones..." 
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            
            <select wire:model.live="filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="todas">Todas las discusiones</option>
                <option value="activas">Activas</option>
                <option value="cerradas">Cerradas</option>
            </select>
        </div>

        <!-- Lista de Discusiones -->
        @if($discussions->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">No hay discusiones aún</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($discussions as $discussion)
                    <a href="{{ route('clubs.discussions.show', $discussion) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-6 border-l-4 @if($discussion->status === 'cerrada') border-red-500 @else border-green-500 @endif">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900">{{ $discussion->title }}</h2>
                                @if($discussion->isResolved())
                                    <span class="text-xs text-green-700 font-semibold">✓ Resuelta</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                @if($discussion->isResolved())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Resuelto
                                    </span>
                                @endif
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($discussion->status === 'cerrada') bg-red-100 text-red-800 @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($discussion->status) }}
                                </span>
                            </div>
                        </div>

                        @if($discussion->description)
                            <p class="text-gray-600 mb-3">{{ Str::limit($discussion->description, 150) }}</p>
                        @endif

                        @if($discussion->book)
                            <div class="mb-3 inline-block">
                                <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                    📖 {{ $discussion->book->title }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <div class="flex gap-4">
                                <span>Por {{ $discussion->creator->name }}</span>
                                <span>{{ $discussion->created_at->diffForHumans() }}</span>
                            </div>
                            <span>{{ $discussion->comments()->count() }} comentario(s)</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $discussions->links() }}
            </div>
        @endif
    </div>
</div>
