<?php

namespace App\Policies;

use App\Models\Concept;
use App\Models\User;

class ConceptPolicy
{
    public function update(User $user, Concept $concept): bool
    {
        return $user->id === $concept->domain->user_id;
    }

    public function delete(User $user, Concept $concept): bool
    {
        return $user->id === $concept->domain->user_id;
    }
}