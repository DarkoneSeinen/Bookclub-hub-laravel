<div class="bg-gray-50 p-4 rounded-lg">
    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @auth
        <button 
            wire:click="$toggle('showForm')" 
            class="mb-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
        >
            @if($showForm) Cancelar @else Escribir reseña @endif
        </button>

        @if($showForm)
            <form wire:submit="submitReview" class="space-y-4">
                <!-- Rating -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Calificación (1-5 estrellas):</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button 
                                type="button"
                                wire:click="$set('rating', {{ $i }})" 
                                class="text-3xl transition @if($rating >= $i) text-yellow-400 @else text-gray-300 @endif hover:text-yellow-400"
                            >
                                ★
                            </button>
                        @endfor
                    </div>
                    @error('rating') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Título -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Título de tu reseña:</label>
                    <input 
                        type="text" 
                        wire:model="title" 
                        placeholder="Ej: Una obra maestra" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Contenido -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tu opinión:</label>
                    <textarea 
                        rows="4" 
                        wire:model="content" 
                        placeholder="Comparte tu opinión sobre el libro..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                    @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold"
                >
                    Publicar Reseña
                </button>
            </form>
        @endif
    @else
        <p class="text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Inicia sesión</a> para escribir una reseña
        </p>
    @endauth
</div>
