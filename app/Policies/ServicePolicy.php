<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->type === 'professional'
            ? Response::allow()
            : Response::deny('You do not have permission to create a service.', 403);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): Response
    {
        return $user->type === 'professional' && $user->id === $service->professional_id
            ? Response::allow()
            : Response::deny('You do not have permission to update this service.', 403);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): Response
    {
        return $user->type === 'professional' && $user->id === $service->professional_id
            ? Response::allow()
            : Response::deny('You do not have permission to update this service.', 403);
    }
}
