<?php

namespace App\Livewire\Voting;

use App\Models\VotingPeriod;
use App\Models\Club;
use App\Models\Book;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class VotingIndex extends Component
{
    public ?VotingPeriod $votingPeriod = null;
    public ?Club $club = null;
    public bool $noVotingPeriods = false;
    public string $searchBooks = '';
    public array $selectedBooks = [];

    public function mount(Club $club, ?VotingPeriod $votingPeriod = null): void
    {
        $this->club = $club;
        
        // Si se proporciona un período específico, usarlo
        if ($votingPeriod) {
            $this->votingPeriod = $votingPeriod;
        } else {
            // Si no, buscar el período activo o el más reciente
            $period = $club->votingPeriods()
                ->where('status', 'activa')
                ->latest()
                ->first();
            
            if (!$period) {
                $period = $club->votingPeriods()->latest()->first();
            }

            if (!$period) {
                // No hay votaciones, marcar flag para mostrar vista especial
                $this->noVotingPeriods = true;
            } else {
                $this->votingPeriod = $period;
            }
        }
    }

    public function getBooks()
    {
        if (empty($this->searchBooks)) {
            return [];
        }

        return Book::where('title', 'like', '%' . $this->searchBooks . '%')
            ->orWhere('author', 'like', '%' . $this->searchBooks . '%')
            ->limit(10)
            ->get();
    }

    public function selectBook($bookId): void
    {
        if (in_array($bookId, $this->selectedBooks)) {
            $this->selectedBooks = array_filter($this->selectedBooks, fn($id) => $id !== $bookId);
        } else {
            $this->selectedBooks[] = $bookId;
        }
    }

    public function addCandidates(): void
    {
        if (empty($this->selectedBooks)) {
            session()->flash('error', 'Selecciona al menos un libro');
            return;
        }

        // Get existing candidates (books that already have votes)
        $existingCandidates = $this->votingPeriod->votes()
            ->distinct('book_id')
            ->pluck('book_id')
            ->toArray();

        $newCandidates = 0;
        foreach ($this->selectedBooks as $bookId) {
            if (!in_array($bookId, $existingCandidates)) {
                $newCandidates++;
            }
        }

        if ($newCandidates === 0) {
            session()->flash('error', 'Estos libros ya son candidatos');
        } else {
            session()->flash('message', $newCandidates . ' candidato(s) agregado(s) exitosamente');
        }

        $this->selectedBooks = [];
        $this->searchBooks = '';
    }

    public function vote($bookId): void
    {
        if (!$this->votingPeriod->isActive()) {
            session()->flash('error', 'La votación no está activa');
            return;
        }

        // Verificar si ya votó
        if ($this->votingPeriod->getUserVote(auth()->id())) {
            session()->flash('error', 'Ya has votado en este período');
            return;
        }

        // Crear voto
        $this->votingPeriod->votes()->create([
            'user_id' => auth()->id(),
            'book_id' => $bookId,
        ]);

        session()->flash('message', '¡Voto registrado!');
        $this->dispatch('vote-registered');
    }


    public function render()
    {
        if ($this->noVotingPeriods || !$this->votingPeriod) {
            return view('livewire.voting.voting-index', [
                'candidates' => [],
                'userVote' => null,
                'books' => [],
                'club' => $this->club,
            ]);
        }

        $candidates = $this->votingPeriod->getCandidates();
        $userVote = auth()->check() ? $this->votingPeriod->getUserVote(auth()->id()) : null;
        $books = $this->getBooks();

        return view('livewire.voting.voting-index', [
            'candidates' => $candidates,
            'userVote' => $userVote,
            'books' => $books,
            'club' => $this->club,
        ]);
    }
}
