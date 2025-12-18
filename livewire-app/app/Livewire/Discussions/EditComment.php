<?php

namespace App\Livewire\Discussions;

use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class EditComment extends Component
{
    public Comment $comment;
    public string $content = '';
    public bool $isEditing = false;

    public function mount(): void
    {
        $this->content = $this->comment->content;
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

    public function save(): void
    {
        $this->validate();
        $this->comment->editContent($this->content);
        $this->isEditing = false;
        $this->dispatch('notify', type: 'success', message: 'Comentario actualizado');
    }

    public function cancel(): void
    {
        $this->content = $this->comment->content;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.discussions.edit-comment');
    }
}
