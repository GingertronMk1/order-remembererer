<?php

namespace App\Observers;

use App\Mail\ModelUpdated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailsAdminsObserver
{
    /**
     * Handle the "created" event.
     *
     * @param  $model
     */
    public function created($model)
    {
        Mail::to(User::where('admin', true)->get()->all())->send(new ModelUpdated('created', $model));
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param  $model
     */
    public function updated($model)
    {
        Mail::to(User::where('admin', true)->get()->all())->send(new ModelUpdated('updated', $model));
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
