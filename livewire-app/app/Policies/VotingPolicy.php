<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Club;
use App\Models\VotingPeriod;

class VotingPolicy
{
    /**
     * Ver cualquier votación del club
     */
    public function viewAny(User $user, Club $club): bool
    {
        // Solo miembros del club
        return $club->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Ver una votación específica
     */
    public function view(User $user, VotingPeriod $votingPeriod): bool
    {
        return $this->viewAny($user, $votingPeriod->club);
    }

    /**
     * Crear nueva votación
     */
    public function create(User $user, Club $club): bool
    {
        // Solo propietario o admin del club
        return $user->id === $club->owner_id || $user->isAdmin();
    }

    /**
     * Votar en una votación
     */
    public function vote(User $user, VotingPeriod $votingPeriod): bool
    {
        // Debe ser miembro del club
        $isMember = $votingPeriod->club->members()->where('user_id', $user->id)->exists();
        // La votación debe estar activa
        $isActive = $votingPeriod->isActive();
        // No debe haber votado ya
        $hasNotVoted = !$votingPeriod->getUserVote($user->id);

        return $isMember && $isActive && $hasNotVoted;
    }

    /**
     * Agregar candidatos a la votación
     */
    public function addCandidates(User $user, VotingPeriod $votingPeriod): bool
    {
        // Solo propietario o admin del club
        return $user->id === $votingPeriod->club->owner_id || $user->isAdmin();
    }

    /**
     * Cerrar votación
     */
    public function close(User $user, VotingPeriod $votingPeriod): bool
    {
        // Solo propietario o admin del club
        return $user->id === $votingPeriod->club->owner_id || $user->isAdmin();
    }
}
