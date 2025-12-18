<div class="mt-2">
    @if($isEditing)
        <form wire:submit="save" class="space-y-2">
            <textarea wire:model="content" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <div class="flex gap-2">
                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    Guardar
                </button>
                <button type="button" wire:click="cancel" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">
                    Cancelar
                </button>
            </div>
        </form>
    @else
        <div>
            <p class="text-gray-700">{{ $comment->content }}</p>
            @if($comment->edited_at)
                <p class="text-xs text-gray-500 mt-1">
                    Editado {{ $comment->edited_at->diffForHumans() }}
                </p>
            @endif
        </div>
    @endif
</div>
