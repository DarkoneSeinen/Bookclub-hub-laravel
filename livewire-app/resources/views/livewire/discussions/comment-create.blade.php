<div class="mt-6 space-y-4">
    @if ($discussion->isOpen())
        <form wire:submit="store" class="space-y-3">
            <div>
                <textarea
                    wire:model="content"
                    placeholder="{{ $parentComment ? 'Responder comentario...' : 'Agregar comentario...' }}"
                    rows="{{ $parentComment ? '3' : '4' }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                ></textarea>
                @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between">
                @if ($parentComment)
                    <button type="button" wire:click="$parent.$set('replyingTo', null)" class="text-gray-500 hover:text-gray-700">
                        Cancelar
                    </button>
                @endif
                <button
                    type="submit"
                    class="ml-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                >
                    {{ $parentComment ? 'Responder' : 'Comentar' }}
                </button>
            </div>
        </form>
    @else
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-800">Esta discusión está cerrada. No se pueden agregar nuevos comentarios.</p>
        </div>
    @endif
</div>
