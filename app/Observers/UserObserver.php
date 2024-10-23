<?php

namespace App\Observers;

use App\Events\UserSaved;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "saved" event.
     *
     * @param  User  $user
     * @return void
     */
    public function saved(User $user)
    {
        Log::info('UserObserver: User saved event fired for user id ' . $user->id);
        event(new UserSaved($user));
    }
}
