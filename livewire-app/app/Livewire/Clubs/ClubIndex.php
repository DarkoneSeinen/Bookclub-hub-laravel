<?php

namespace App\Livewire\Clubs;

use App\Models\Club;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ClubIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $clubs = Club::where('is_private', false)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->with('owner')
            ->paginate(12);

        return view('livewire.clubs.club-index', [
            'clubs' => $clubs,
        ]);
    }
}
