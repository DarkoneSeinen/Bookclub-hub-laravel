<div class="bg-white rounded-lg shadow p-4 mb-4 ml-{{ $comment->isReply() ? '8' : '0' }}">
    <div class="flex justify-between items-start mb-2">
        <div class="flex items-center gap-3">
            @if($comment->user->avatar)
                <img src="{{ Storage::url($comment->user->avatar) }}" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full object-cover">
            @else
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-xs font-semibold text-blue-600">{{ $comment->user->initials() }}</span>
                </div>
            @endif
            <div>
                <p class="font-medium text-gray-900">{{ $comment->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>

        @auth
            @if(auth()->user()->id === $comment->user_id || auth()->user()->isAdmin())
                <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="¿Eliminar este comentario?"
                        class="text-red-600 hover:text-red-700 text-sm">
                    Eliminar
                </button>
            @endif
        @endauth
    </div>

    <p class="text-gray-700 mb-3">{{ $comment->content }}</p>

    <!-- Replies -->
    @if($comment->replies->isNotEmpty())
        <div class="space-y-3 mt-4 pt-4 border-t border-gray-200">
            @foreach($comment->replies as $reply)
                @include('livewire.discussions.comment-item', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
