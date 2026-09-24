<?php

namespace App\Policies;

use App\Models\Borrowing;
use App\Models\User;

class BorrowingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [User::ROLE_IT_SUPPORT, User::ROLE_USER_BUILDING], true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Borrowing $borrowing): bool
    {
        return $user->role === User::ROLE_IT_SUPPORT || $borrowing->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === User::ROLE_USER_BUILDING && $user->building_id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Borrowing $borrowing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Borrowing $borrowing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Borrowing $borrowing): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Borrowing $borrowing): bool
    {
        return false;
    }

    public function approve(User $user, Borrowing $borrowing): bool
    {
        return $user->role === User::ROLE_IT_SUPPORT
            && $borrowing->status === Borrowing::STATUS_PENDING;
    }

    public function reject(User $user, Borrowing $borrowing): bool
    {
        return $this->approve($user, $borrowing);
    }

    public function receive(User $user, Borrowing $borrowing): bool
    {
        return $user->id === $borrowing->user_id
            && $borrowing->status === Borrowing::STATUS_APPROVED;
    }

    public function requestReturn(User $user, Borrowing $borrowing): bool
    {
        return $user->id === $borrowing->user_id
            && $borrowing->status === Borrowing::STATUS_BORROWED;
    }

    public function returnBorrowing(User $user, Borrowing $borrowing): bool
    {
        return $user->role === User::ROLE_IT_SUPPORT
            && in_array($borrowing->status, [Borrowing::STATUS_APPROVED, Borrowing::STATUS_BORROWED, Borrowing::STATUS_PENDING_RETURN], true);
    }
}
