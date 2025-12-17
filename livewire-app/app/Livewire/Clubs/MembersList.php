<?php

namespace App\Livewire\Clubs;

use App\Models\Club;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('components.layouts.app')]
class MembersList extends Component
{
    use AuthorizesRequests;

    public Club $club;
    public string $search = '';

    public function mount(Club $club)
    {
        $this->club = $club;
    }

    public function removeMember($userId)
    {
        $this->authorize('update', $this->club);

        $this->club->members()->detach($userId);
        session()->flash('message', 'Miembro removido del club');
    }

    public function updateRole($userId, $role)
    {
        $this->authorize('update', $this->club);

        if (!in_array($role, ['owner', 'moderator', 'member'])) {
            return;
        }

        $this->club->members()->updateExistingPivot($userId, ['role' => $role]);
        session()->flash('message', 'Rol actualizado');
    }

    public function render()
    {
        $members = $this->club->members()
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->paginate(15);

        return view('livewire.clubs.members-list', [
            'members' => $members,
        ]);
    }
}
