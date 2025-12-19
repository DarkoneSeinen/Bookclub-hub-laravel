<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">📊 Historial de Votaciones</h1>
        
        <!-- Filter Tabs -->
        <div class="flex gap-2 mb-6 border-b border-gray-200">
            <button wire:click="setFilter('all')" 
                    @class(['px-4 py-2 font-medium transition border-b-2', 
                            'border-blue-600 text-blue-600' => $filter === 'all',
                            'border-transparent text-gray-600 hover:text-gray-900' => $filter !== 'all'])>
                Todas
            </button>
            <button wire:click="setFilter('active')" 
                    @class(['px-4 py-2 font-medium transition border-b-2', 
                            'border-blue-600 text-blue-600' => $filter === 'active',
                            'border-transparent text-gray-600 hover:text-gray-900' => $filter !== 'active'])>
                Activas
            </button>
            <button wire:click="setFilter('completed')" 
                    @class(['px-4 py-2 font-medium transition border-b-2', 
                            'border-blue-600 text-blue-600' => $filter === 'completed',
                            'border-transparent text-gray-600 hover:text-gray-900' => $filter !== 'completed'])>
                Completadas
            </button>
            <button wire:click="setFilter('closed')" 
                    @class(['px-4 py-2 font-medium transition border-b-2', 
                            'border-blue-600 text-blue-600' => $filter === 'closed',
                            'border-transparent text-gray-600 hover:text-gray-900' => $filter !== 'closed'])>
                Cerradas
            </button>
        </div>

        @if($votings->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500 text-lg">No hay votaciones {{ $filter !== 'all' ? "en estado '$filter'" : '' }}</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($votings as $voting)
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $voting->title }}</h3>
                                <p class="text-gray-600 mt-1">{{ $voting->description }}</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($voting->status === 'activa') bg-green-100 text-green-800
                                @elseif($voting->status === 'completada') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($voting->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-xs text-gray-600 uppercase tracking-wide">Inicio</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $voting->start_date->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-xs text-gray-600 uppercase tracking-wide">Cierre</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $voting->end_date->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-xs text-gray-600 uppercase tracking-wide">Votos Totales</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $voting->votes()->count() }}</p>
                            </div>
                        </div>

                        @if($voting->winner_book_id && $voting->status === 'completada')
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm font-semibold text-blue-900 mb-2">🏆 Ganador</p>
                                <div class="flex gap-4">
                                    @if($voting->winnerBook->cover_image)
                                        <img src="{{ Storage::url($voting->winnerBook->cover_image) }}" 
                                             alt="{{ $voting->winnerBook->title }}" 
                                             class="w-16 h-24 object-cover rounded">
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $voting->winnerBook->title }}</h4>
                                        <p class="text-gray-600">{{ $voting->winnerBook->author }}</p>
                                        <p class="text-sm text-blue-600 font-semibold mt-2">
                                            {{ $voting->getVoteCount($voting->winner_book_id) }} votos
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($voting->status === 'activa')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <a href="{{ route('clubs.voting.show', [$club, $voting]) }}" 
                                   class="text-green-700 font-semibold hover:text-green-900">
                                    Ver votación activa →
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8 border-t pt-6">
            <a href="{{ route('clubs.show', $club) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                ← Volver al club
            </a>
        </div>
    </div>
</div>
