<?php

namespace App\Livewire\Voting;

use App\Models\Club;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class VotingHistory extends Component
{
    public Club $club;
    public string $filter = 'all'; // all, completed, active, closed

    public function mount(Club $club): void
    {
        $this->club = $club;
    }

    public function setFilter($filterValue): void
    {
        $this->filter = $filterValue;
    }

    public function render()
    {
        $votings = $this->club->votingPeriods();

        // Apply filter
        if ($this->filter === 'completed') {
            $votings = $votings->where('status', 'completada');
        } elseif ($this->filter === 'active') {
            $votings = $votings->where('status', 'activa');
        } elseif ($this->filter === 'closed') {
            $votings = $votings->where('status', 'cerrada');
        }

        $votings = $votings->with('winnerBook')->latest()->get();

        return view('livewire.voting.voting-history', [
            'votings' => $votings,
        ]);
    }
}
