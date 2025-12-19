<div class="max-w-6xl mx-auto py-8 px-4">
    @if($noVotingPeriods)
        <!-- No Voting Periods Message -->
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <div class="mb-6">
                <div class="text-6xl mb-4">🗳️</div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">No hay votaciones activas</h1>
                <p class="text-gray-600 mb-6">Este club aún no ha iniciado ninguna votación para elegir el próximo libro.</p>
            </div>

            @auth
                @if(auth()->user()->id === $club->owner_id || auth()->user()->isAdmin())
                    <a href="{{ route('clubs.voting.create', $club) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        + Iniciar Primera Votación
                    </a>
                @else
                    <p class="text-gray-500">Contáctate con el administrador del club para iniciar una votación.</p>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    Inicia Sesión
                </a>
            @endauth

            <div class="mt-8 border-t pt-8">
                <a href="{{ route('clubs.show', $club) }}" class="text-blue-600 hover:text-blue-700">
                    ← Volver al club
                </a>
            </div>
        </div>
    @else
    <!-- Flash Messages -->
    @if(session('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    @if(session('info'))
        <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg">
            {{ session('info') }}
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $votingPeriod->title }}</h1>
                <p class="text-gray-600 mt-1">{{ $club->name }}</p>
                @if($votingPeriod->description)
                    <p class="text-gray-600 mt-2">{{ $votingPeriod->description }}</p>
                @endif
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                    @if($votingPeriod->isActive()) bg-green-100 text-green-800
                    @elseif($votingPeriod->isClosed()) bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($votingPeriod->status) }}
                </span>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Comienza</p>
                    <p class="font-semibold text-gray-900">{{ $votingPeriod->start_date->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex-1 border-t-2 border-gray-300"></div>
                <div>
                    <p class="text-gray-600">Termina</p>
                    <p class="font-semibold text-gray-900">{{ $votingPeriod->end_date->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        @if($votingPeriod->winner_book_id && $votingPeriod->status === 'completada')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-green-800">
                    ✓ <strong>Ganador:</strong> {{ $votingPeriod->winnerBook->title }}
                    ({{ $votingPeriod->getVoteCount($votingPeriod->winner_book_id) }} votos)
                </p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Candidatos -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">📚 Libros en Votación</h2>

                @if($candidates->isEmpty())
                    <p class="text-gray-500 text-center py-8">No hay libros en votación aún</p>
                @else
                    <div class="space-y-4">
                        @foreach($candidates as $book)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                                <div class="flex gap-4">
                                    @if($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-20 h-28 object-cover rounded">
                                    @else
                                        <div class="w-20 h-28 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400">📖</span>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $book->title }}</h3>
                                        <p class="text-gray-600">{{ $book->author }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($book->description, 100) }}</p>

                                        <!-- Vote Count -->
                                        <div class="mt-3">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $votingPeriod->getVoteCount($book->id) > 0 ? min(($votingPeriod->getVoteCount($book->id) / $votingPeriod->votes()->count() * 100), 100) : 0 }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900">
                                                    {{ $votingPeriod->getVoteCount($book->id) }}
                                                    @if($votingPeriod->votes()->count() > 0)
                                                        ({{ round($votingPeriod->getVoteCount($book->id) / $votingPeriod->votes()->count() * 100) }}%)
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vote Button -->
                                    @auth
                                        @if($votingPeriod->isActive())
                                            <button wire:click="vote({{ $book->id }})"
                                                    @if($userVote?->book_id === $book->id) disabled @endif
                                                    @class([
                                                        'px-4 py-2 rounded-lg transition h-fit',
                                                        'bg-blue-600 text-white hover:bg-blue-700' => $userVote?->book_id !== $book->id,
                                                        'bg-green-600 text-white' => $userVote?->book_id === $book->id,
                                                    ])>
                                                @if($userVote?->book_id === $book->id)
                                                    ✓ Votado
                                                @else
                                                    Votar
                                                @endif
                                            </button>
                                        @else
                                            <div class="text-xs text-gray-500">Votación cerrada</div>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm h-fit">
                                            Loguéate
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Información -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Estadísticas</h3>
                
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <p class="text-gray-600 text-sm">Candidatos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($candidates) }}</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <p class="text-gray-600 text-sm">Total de Votos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $votingPeriod->votes()->count() }}</p>
                    </div>
                    
                    @if($votingPeriod->isActive())
                        <div class="bg-blue-50 rounded p-3 mt-4">
                            <p class="text-sm text-blue-800">
                                <strong>Votación Activa</strong><br>
                                Termina el {{ $votingPeriod->end_date->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            @auth
                @if(auth()->user()->id === $club->owner_id || auth()->user()->isAdmin())
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">⚙️ Acciones Admin</h3>
                        
                        <p class="text-sm text-gray-600 mb-4">Como administrador del club, puedes:</p>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>✓ Ver resultados en tiempo real</li>
                            <li>✓ Cerrar la votación manualmente</li>
                            <li>✓ Ver historial de votaciones</li>
                        </ul>
                    </div>
                @endif
            @endauth
        </div>
    </div>
    @endif
</div>
