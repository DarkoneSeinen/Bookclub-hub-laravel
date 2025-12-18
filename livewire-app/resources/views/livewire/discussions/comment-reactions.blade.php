<div class="flex gap-2 mt-2">
    @foreach($emojis as $emoji)
        <button 
            wire:click="toggleReaction('{{ $emoji }}')"
            @class([
                'px-2 py-1 rounded-full text-sm transition',
                'bg-blue-100 text-blue-700' => $comment->hasUserReacted(auth()?->id(), $emoji),
                'hover:bg-gray-100 text-gray-600' => !$comment->hasUserReacted(auth()?->id(), $emoji),
            ])
        >
            {{ $emoji }} <span class="ml-1 text-xs">{{ $comment->getReactionCount($emoji) }}</span>
        </button>
    @endforeach
</div>
