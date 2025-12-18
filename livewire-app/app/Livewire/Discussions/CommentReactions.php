<?php

namespace App\Livewire\Discussions;

use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CommentReactions extends Component
{
    public Comment $comment;
    public array $emojis = ['👍', '❤️', '😂', '😮', '😢', '😡'];

    public function toggleReaction(string $emoji): void
    {
        if (!auth()->check()) {
            $this->dispatch('notify', type: 'error', message: 'Debes estar logueado');
            return;
        }

        $this->comment->toggleReaction(auth()->id(), $emoji);
        $this->dispatch('reaction-toggled');
    }

    public function render()
    {
        return view('livewire.discussions.comment-reactions');
    }
}
