<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountabilityObserver
{
    public function creating($model)
    {
        if($model->user_id === null) {
            $user = Auth::user() ? Auth::user() : User::get()->firstWhere('admin', true);
            $model->user_id = $user->id;
        }
    }
}
