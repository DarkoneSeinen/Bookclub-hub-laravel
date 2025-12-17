<?php

namespace App\Livewire\Clubs;

use App\Models\Club;
use App\Models\Book;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ClubCreate extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $description = '';
    public bool $is_private = false;
    public int $max_members = 0;
    public $cover_image;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'is_private' => 'boolean',
            'max_members' => 'nullable|integer|min:1|max:1000',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($this->cover_image) {
            $path = $this->cover_image->store('clubs', 'public');
        }

        Club::create([
            'name' => $this->name,
            'description' => $this->description,
            'owner_id' => auth()->id(),
            'cover_image' => $path,
            'is_private' => $this->is_private,
            'max_members' => $this->max_members ?: null,
        ]);

        session()->flash('message', 'Club creado exitosamente');
        $this->redirect('/clubs');
    }

    public function render()
    {
        return view('livewire.clubs.club-create');
    }
}
