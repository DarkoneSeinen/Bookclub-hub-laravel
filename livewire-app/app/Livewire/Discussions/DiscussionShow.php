<?php

namespace App\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class DiscussionShow extends Component
{
    public Discussion $discussion;
    public string $newComment = '';

    public function mount(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|min:3|max:1000',
        ]);

        if (!$this->discussion->isOpen()) {
            session()->flash('error', 'Esta discusión está cerrada');
            return;
        }

        Comment::create([
            'discussion_id' => $this->discussion->id,
            'user_id' => auth()->id(),
            'content' => $this->newComment,
        ]);

        $this->newComment = '';
        session()->flash('message', 'Comentario agregado');
        $this->redirect(route('clubs.discussions.show', $this->discussion));
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);

        if ($comment && ($comment->user_id === auth()->id() || auth()->user()->isAdmin())) {
            $comment->delete();
            session()->flash('message', 'Comentario eliminado');
        }
    }

    public function closeDiscussion()
    {
        if ($this->discussion->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            return;
        }

        $this->discussion->close();
        session()->flash('message', 'Discusión cerrada');
        $this->redirect(route('clubs.discussions.show', $this->discussion));
    }

    public function reopenDiscussion()
    {
        if ($this->discussion->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            return;
        }

        $this->discussion->reopen();
        session()->flash('message', 'Discusión reabierta');
        $this->redirect(route('clubs.discussions.show', $this->discussion));
    }

    public function toggleResolved()
    {
        if ($this->discussion->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            return;
        }

        if ($this->discussion->isResolved()) {
            $this->discussion->markAsUnresolved();
            session()->flash('message', 'Discusión marcada como no resuelta');
        } else {
            $this->discussion->markAsResolved();
            session()->flash('message', 'Discusión marcada como resuelta');
        }
    }

    public function render()
    {
        $rootComments = $this->discussion->rootComments()
            ->with('repliesRecursive')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.discussions.discussion-show', [
            'rootComments' => $rootComments,
        ]);
    }
}
