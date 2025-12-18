<?php

namespace App\Livewire\Discussions;

use App\Models\Club;
use App\Models\Book;
use App\Models\Discussion;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class DiscussionCreate extends Component
{
    public Club $club;
    public string $title = '';
    public string $description = '';
    public ?int $book_id = null;
    public string $search = '';
    public array $searchResults = [];

    public function mount(Club $club)
    {
        $this->club = $club;
    }

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Book::where('title', 'like', "%{$this->search}%")
            ->orWhere('author', 'like', "%{$this->search}%")
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function selectBook($bookId)
    {
        $this->book_id = $bookId;
        $this->search = '';
        $this->searchResults = [];
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|min:5|max:255',
            'description' => 'nullable|string|max:1000',
            'book_id' => 'nullable|exists:books,id',
        ]);

        Discussion::create([
            'club_id' => $this->club->id,
            'title' => $this->title,
            'description' => $this->description,
            'book_id' => $this->book_id,
            'created_by' => auth()->id(),
        ]);

        session()->flash('message', 'Discusión creada exitosamente');
        $this->redirect(route('clubs.discussions.index', $this->club));
    }

    public function render()
    {
        $selectedBook = $this->book_id ? Book::find($this->book_id) : null;

        return view('livewire.discussions.discussion-create', [
            'selectedBook' => $selectedBook,
        ]);
    }
}
