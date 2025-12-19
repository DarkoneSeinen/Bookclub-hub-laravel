<?php

namespace App\Livewire\Voting;

use App\Models\Club;
use App\Models\VotingPeriod;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class VotingManager extends Component
{
    public Club $club;
    public string $title = 'Votación para próximo libro';
    public string $description = '';
    public string $start_date = '';
    public string $end_date = '';

    public function mount(Club $club): void
    {
        $this->club = $club;
        // Pre-llenar con fechas por defecto (hoy a 7 días)
        // Use format compatible with datetime-local inputs (Y-m-d\TH:i)
        $this->start_date = now()->format('Y-m-d\TH:i');
        $this->end_date = now()->addDays(7)->format('Y-m-d\TH:i');
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date_format:Y-m-d H:i|after_or_equal:now',
            'end_date' => 'required|date_format:Y-m-d H:i|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es requerido',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o posterior',
            'end_date.after' => 'La fecha de cierre debe ser posterior a la de inicio',
        ];
    }

    public function startVoting(): void
    {
        // Convert datetime-local format (Y-m-d\TH:i) to format expected by validation (Y-m-d H:i)
        if (strpos($this->start_date, 'T') !== false) {
            $this->start_date = str_replace('T', ' ', $this->start_date);
        }
        if (strpos($this->end_date, 'T') !== false) {
            $this->end_date = str_replace('T', ' ', $this->end_date);
        }

        $this->validate();

        // Solo el owner o admin pueden crear votaciones
        if ($this->club->owner_id !== auth()->id() && !auth()->user()->isAdmin()) {
            session()->flash('error', 'No tienes permiso para crear votaciones');
            return;
        }

        VotingPeriod::create([
            'club_id' => $this->club->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        session()->flash('message', 'Votación iniciada exitosamente');
        $this->redirect(route('clubs.voting.index', $this->club));
    }

    public function render()
    {
        return view('livewire.voting.voting-manager');
    }
}
