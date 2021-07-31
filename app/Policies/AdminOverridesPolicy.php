<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminOverridesPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param string $ability
     *
     * @return bool|void
     */
    public function before(User $user, $ability)
    {
        if($user->admin) {
            return true;
        }
    }
}
