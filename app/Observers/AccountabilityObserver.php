<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountabilityObserver
{
    public function creating($model) {
        $user = Auth::user() ? Auth::user() : User::get()->firstWhere('admin', true);
        $model->user_id = $user->id;
    }
}
