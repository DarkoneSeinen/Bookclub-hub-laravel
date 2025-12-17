<?php

namespace App\Livewire\Clubs;

use App\Models\Club;
use App\Models\Reading;
use App\Models\Book;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app')]
class ReadingForm extends Component
{
    use AuthorizesRequests;

    public Club $club;
    public ?Reading $reading = null;
    public ?int $book_id = null;
    public string $status = 'planeado';
    public ?string $start_date = null;
    public ?string $end_date = null;
    public string $search = '';
    public array $searchResults = [];

    public function mount(Club $club, ?int $reading = null)
    {
        $this->authorize('update', $club);

        $this->club = $club;
        
        if ($reading) {
            $readingModel = Reading::findOrFail($reading);
            $this->reading = $readingModel;
            $this->book_id = $readingModel->book_id;
            $this->status = $readingModel->status;
            $this->start_date = $readingModel->start_date?->format('Y-m-d');
            $this->end_date = $readingModel->end_date?->format('Y-m-d');
        }
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
        $this->authorize('update', $this->club);

        $this->validate([
            'book_id' => 'required|exists:books,id',
            'status' => 'required|in:planeado,en_curso,completado',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($this->reading) {
            $this->reading->update([
                'book_id' => $this->book_id,
                'status' => $this->status,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
        } else {
            Reading::create([
                'club_id' => $this->club->id,
                'book_id' => $this->book_id,
                'status' => $this->status,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
        }

        session()->flash('message', $this->reading ? 'Lectura actualizada' : 'Lectura creada');
        $this->redirect(route('clubs.show', $this->club));
    }

    public function render()
    {
        $selectedBook = $this->book_id ? Book::find($this->book_id) : null;

        return view('livewire.clubs.reading-form', [
            'selectedBook' => $selectedBook,
        ]);
    }
}
