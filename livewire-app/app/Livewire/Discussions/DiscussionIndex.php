<?php

namespace App\Livewire\Discussions;

use App\Models\Club;
use App\Models\Discussion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class DiscussionIndex extends Component
{
    use WithPagination;

    public Club $club;
    public string $search = '';
    public string $filter = 'todas'; // todas, activas, cerradas

    public function mount(Club $club)
    {
        $this->club = $club;
    }

    public function render()
    {
        $discussions = $this->club->discussions()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->filter === 'activas', function ($query) {
                $query->where('status', 'activa');
            })
            ->when($this->filter === 'cerradas', function ($query) {
                $query->where('status', 'cerrada');
            })
            ->with('creator', 'book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.discussions.discussion-index', [
            'discussions' => $discussions,
        ]);
    }
}
