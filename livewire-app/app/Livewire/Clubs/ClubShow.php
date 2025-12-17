<?php

namespace App\Livewire\Clubs;

use App\Models\Club;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ClubShow extends Component
{
    public Club $club;

    public function mount(Club $club)
    {
        $this->club = $club;
    }

    public function joinClub()
    {
        $user = auth()->user();

        if ($this->club->isMember($user)) {
            session()->flash('error', 'Ya eres miembro de este club');
            return;
        }

        if ($this->club->max_members && $this->club->members()->count() >= $this->club->max_members) {
            session()->flash('error', 'El club ha alcanzado su límite de miembros');
            return;
        }

        $this->club->members()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        session()->flash('message', 'Te has unido al club exitosamente');
        $this->redirect(route('clubs.show', $this->club));
    }

    public function leaveClub()
    {
        $user = auth()->user();

        if ($this->club->isOwner($user)) {
            session()->flash('error', 'El propietario no puede abandonar el club');
            return;
        }

        $this->club->members()->detach($user->id);
        session()->flash('message', 'Has abandonado el club');
        $this->redirect(route('clubs.index'));
    }

    public function render()
    {
        return view('livewire.clubs.club-show', [
            'isMember' => $this->club->isMember(auth()->user()),
            'members' => $this->club->members()->paginate(10),
            'readings' => $this->club->readings()->with('book')->latest()->get(),
        ]);
    }
}
