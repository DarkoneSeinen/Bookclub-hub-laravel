<?php

namespace App\Livewire\Discussions;

use App\Models\Comment;
use App\Models\Discussion;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CommentCreate extends Component
{
    public Discussion $discussion;
    public ?Comment $parentComment = null;
    public string $content = '';

    public function mount(Discussion $discussion, ?Comment $parentComment = null): void
    {
        $this->discussion = $discussion;
        $this->parentComment = $parentComment;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:3|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'El contenido es requerido',
            'content.min' => 'El comentario debe tener al menos 3 caracteres',
            'content.max' => 'El comentario no puede exceder 2000 caracteres',
        ];
    }

    public function store(): void
    {
        if (!$this->discussion->isOpen()) {
            $this->dispatch('notify', type: 'error', message: 'Esta discusión está cerrada');
            return;
        }

        $this->validate();

        Comment::create([
            'discussion_id' => $this->discussion->id,
            'user_id' => auth()->id(),
            'content' => $this->content,
            'parent_comment_id' => $this->parentComment?->id,
        ]);

        $this->content = '';
        $this->dispatch('comment-created');
        $this->dispatch('notify', type: 'success', message: 'Comentario creado exitosamente');
    }

    public function render()
    {
        return view('livewire.discussions.comment-create');
    }
}
