<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Encabezado de Discusión -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-start mb-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $discussion->title }}</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($discussion->status === 'cerrada') bg-red-100 text-red-800 @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst($discussion->status) }}
                    </span>
                </div>

                @if($discussion->book)
                    <div class="mb-2">
                        <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                            📖 {{ $discussion->book->title }}
                        </span>
                    </div>
                @endif

                <p class="text-gray-600">
                    Por <strong>{{ $discussion->creator->name }}</strong> • {{ $discussion->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            @auth
                @if(auth()->user()->id === $discussion->created_by || auth()->user()->isAdmin())
                    <div class="flex gap-2 flex-wrap">
                        @if($discussion->isOpen())
                            <button wire:click="closeDiscussion" wire:confirm="¿Cerrar esta discusión?" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                Cerrar
                            </button>
                        @else
                            <button wire:click="reopenDiscussion" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                                Reabrir
                            </button>
                        @endif
                        
                        @if($discussion->isResolved())
                            <button wire:click="toggleResolved" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                ✓ Resuelta - Desmarcar
                            </button>
                        @else
                            <button wire:click="toggleResolved" 
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm">
                                Marcar como Resuelta
                            </button>
                        @endif
                    </div>
                @endif
            @endauth
        </div>

        @if($discussion->description)
            <p class="text-gray-700">{{ $discussion->description }}</p>
        @endif
    </div>

    <!-- Comentarios -->
    <div class="space-y-6">
        @if($discussion->isOpen())
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Agregar Comentario</h2>

                @auth
                    <form wire:submit="addComment" class="space-y-4">
                        <textarea wire:model="newComment" placeholder="Escribe tu comentario..." rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        @error('newComment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Comentar
                        </button>
                    </form>
                @else
                    <p class="text-gray-600"><a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700">Inicia sesión</a> para comentar</p>
                @endauth
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800">Esta discusión está cerrada. No se pueden agregar nuevos comentarios.</p>
            </div>
        @endif

        <!-- Árbol de Comentarios -->
        @if($rootComments->isEmpty())
            <div class="text-center py-8 bg-white rounded-lg shadow">
                <p class="text-gray-500">No hay comentarios aún. ¡Sé el primero en comentar!</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($rootComments as $comment)
                    @include('livewire.discussions.comment-item', ['comment' => $comment])
                @endforeach
            </div>
        @endif
    </div>

    <!-- Volver -->
    <div class="mt-8">
        <a href="{{ route('clubs.discussions.index', $discussion->club) }}" class="text-blue-600 hover:text-blue-700 font-medium">
            ← Volver a Discusiones
        </a>
    </div>
</div>
