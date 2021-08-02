<?php

namespace App\Observers;

use App\Mail\EmailsAdmins;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailsAdminsObserver
{
    private $users;

    public function __construct()
    {
        $this->users = User::where('admin', true)->get()->all();
    }

    /**
     * Handle the "created" event.
     *
     * @param  $model
     */
    public function created($model)
    {
        Mail::to($this->users)->send(new EmailsAdmins('created', $model));
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param  $model
     */
    public function updated($model)
    {
        Mail::to(User::where('admin', true)->get()->all())->send(new EmailsAdmins('updated', $model));
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @param  $model
     */
    public function deleted($model)
    {
    }

    /**
     * Handle the Model "restored" event.
     *
     * @param  $model
     */
    public function restored($model)
    {
    }

    /**
     * Handle the Model "force deleted" event.
     *
     * @param  $model
     */
    public function forceDeleted($model)
    {
    }
}
