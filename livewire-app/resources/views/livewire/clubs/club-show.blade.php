<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Club Header -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="relative h-48 bg-gradient-to-r from-blue-400 to-blue-600">
            @if($club->cover_image)
                <img src="{{ Storage::url($club->cover_image) }}" alt="{{ $club->name }}" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="px-6 py-4 -mt-12 relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $club->name }}</h1>
                    <p class="text-gray-600">Creado por <strong>{{ $club->owner->name }}</strong></p>
                </div>

                <div>
                    @auth
                        @if($isMember)
                            <button wire:click="leaveClub" class="px-6 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition">
                                Abandonar Club
                            </button>
                        @else
                            <button wire:click="joinClub" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Unirse al Club
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 my-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-2xl font-bold text-gray-900">{{ $club->members()->count() }}</p>
                    <p class="text-gray-600">Miembros</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-2xl font-bold text-gray-900">{{ $club->readings()->count() }}</p>
                    <p class="text-gray-600">Libros</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">{{ $club->created_at->format('d/m/Y') }}</p>
                    <p class="text-gray-600">Creado</p>
                </div>
            </div>

            @if($club->description)
                <p class="text-gray-700 text-lg">{{ $club->description }}</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Current Book -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Lecturas Actuales</h2>

                @if($readings->isEmpty())
                    <p class="text-gray-500">No hay lecturas registradas</p>
                @else
                    <div class="space-y-4">
                        @foreach($readings as $reading)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                                <div class="flex gap-4">
                                    @if($reading->book->cover_image)
                                        <img src="{{ Storage::url($reading->book->cover_image) }}" alt="{{ $reading->book->title }}" class="w-24 h-32 object-cover rounded">
                                    @else
                                        <div class="w-24 h-32 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.753 2 16.253S6.5 26.253 12 26.253s10-4.5 10-10V6.253m0 0c5.5.5 10 5 10 10.5s-4.5 10-10 10"></path>
                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $reading->book->title }}</h3>
                                        <p class="text-gray-600">{{ $reading->book->author }}</p>
                                        
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                @if($reading->status === 'planeado') bg-yellow-100 text-yellow-800
                                                @elseif($reading->status === 'en_curso') bg-blue-100 text-blue-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $reading->status)) }}
                                            </span>
                                        </div>

                                        @if($reading->start_date)
                                            <p class="text-sm text-gray-500 mt-2">
                                                Del {{ $reading->start_date->format('d/m/Y') }} 
                                                @if($reading->end_date)al {{ $reading->end_date->format('d/m/Y') }}@endif
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Members -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Miembros</h2>

                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($members as $member)
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                            @if($member->avatar)
                                <img src="{{ Storage::url($member->avatar) }}" alt="{{ $member->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-blue-600">{{ $member->initials() }}</span>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ $member->pivot->role }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($members->hasMorePages())
                    <a href="#" class="mt-4 text-sm text-blue-600 hover:text-blue-700">Ver más miembros</a>
                @endif
            </div>
        </div>
    </div>
</div>
