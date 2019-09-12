<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User as Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->can('get_list_users');
    }

    /**
     * Determine whether the user can show the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $member
     *
     * @return mixed
     */
    public function show_detail_a_user(User $user, Member $member)
    {
        if ($user->hasRole('admin') || ($user->id === $member->id)) {
            return true;
        }
         return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, Member $member)
    {
        if ($user->hasRole('admin') || ($user->hasRole('member') && ($user->id === $member->id))) {
            return $user->can('edit_user');
        }
         return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, Member $model)
    {
        return $user->can('delete_user');
    }
}
