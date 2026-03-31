<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function update(User $user, Application $app): bool
    {
        return ($user->role === 'admin') || ($app->user_id === $user->id);
    }

    public function upload(User $user, Application $app): bool
    {
        return ($user->role === 'admin') || ($app->user_id === $user->id);
    }

}
