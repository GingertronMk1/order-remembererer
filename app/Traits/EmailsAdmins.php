<?php

namespace App\Traits;

use App\Observers\EmailsAdminsObserver;

trait EmailsAdmins
{
    public static function bootEmailsAdmins()
    {
        static::observe(EmailsAdminsObserver::class);
    }
}
