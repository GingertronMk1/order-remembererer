<?php

namespace App\Traits;

use App\Observers\AccountabilityObserver;

trait Accountable
{
    public static function bootAccountable()
    {
        static::observe(AccountabilityObserver::class);
    }
}
