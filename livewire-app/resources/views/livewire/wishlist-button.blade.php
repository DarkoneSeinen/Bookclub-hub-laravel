<div>
    <button 
        wire:click="toggleWishlist" 
        class="w-full @if($isInWishlist) bg-red-500 hover:bg-red-600 @else bg-gray-300 hover:bg-gray-400 @endif text-white py-2 rounded-lg transition font-semibold"
    >
        @if($isInWishlist) En Favoritos @else Agregar a Favoritos @endif
    </button>

    @if(session()->has('message'))
        <p class="text-sm mt-2 text-gray-600">{{ session('message') }}</p>
    @endif
</div>
