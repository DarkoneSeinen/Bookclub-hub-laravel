<div class="space-y-4">
    @if(session()->has('message'))
        <div class="p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="addToCart" class="space-y-4">
        <!-- Cantidad -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Cantidad:</label>
            <input 
                type="number" 
                wire:model="quantity" 
                min="1" 
                max="10" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Botón -->
        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold @if(!$this->book->isAvailable()) opacity-50 cursor-not-allowed @endif"
            @if(!$this->book->isAvailable()) disabled @endif
        >
            🛒 Agregar al Carrito
        </button>
    </form>
</div>
