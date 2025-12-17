<?php

namespace App\Livewire\Clubs;

use App\Models\Club;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app')]
class ClubSettings extends Component
{
    use AuthorizesRequests;

    public Club $club;
    public string $name = '';
    public string $description = '';
    public bool $is_private = false;
    public ?int $max_members = null;
    public bool $showDeleteModal = false;

    public function mount(Club $club)
    {
        $this->authorize('update', $club);
        
        $this->club = $club;
        $this->name = $club->name;
        $this->description = $club->description ?? '';
        $this->is_private = $club->is_private;
        $this->max_members = $club->max_members;
    }

    public function update()
    {
        $this->authorize('update', $this->club);

        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'is_private' => 'boolean',
            'max_members' => 'nullable|integer|min:1|max:1000',
        ]);

        $this->club->update([
            'name' => $this->name,
            'description' => $this->description,
            'is_private' => $this->is_private,
            'max_members' => $this->max_members ?: null,
        ]);

        session()->flash('message', 'Club actualizado exitosamente');
        $this->redirect(route('clubs.show', $this->club));
    }

    public function deleteClub()
    {
        $this->authorize('delete', $this->club);

        $this->club->delete();
        
        session()->flash('message', 'Club eliminado exitosamente');
        $this->redirect(route('clubs.index'));
    }

    public function render()
    {
        return view('livewire.clubs.club-settings');
    }
}
