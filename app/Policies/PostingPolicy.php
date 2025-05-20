<?php

namespace App\Policies;

use App\Models\PostingModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostingModel $postingModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if( $user->postings()->count() < $user->subscription->features->max_posts ){
            return true;
        }

        if( $user->postings()->count() == $user->subscription->features->max_posts ){
            return Response::denyWithStatus(403, 'You have reached the maximum number of postings.');
        }  
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostingModel $postingModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostingModel $postingModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostingModel $postingModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostingModel $postingModel): bool
    {
        return false;
    }
}
