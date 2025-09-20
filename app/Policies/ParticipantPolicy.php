<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Participant;
use App\Models\User;

class ParticipantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Participant');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Participant $participant): bool
    {
        return $user->checkPermissionTo('view Participant');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Participant');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Participant $participant): bool
    {
        return $user->checkPermissionTo('update Participant');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Participant $participant): bool
    {
        return $user->checkPermissionTo('delete Participant');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Participant');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Participant $participant): bool
    {
        return $user->checkPermissionTo('restore Participant');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Participant');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Participant $participant): bool
    {
        return $user->checkPermissionTo('replicate Participant');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Participant');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Participant $participant): bool
    {
        return $user->checkPermissionTo('force-delete Participant');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Participant');
    }
}
