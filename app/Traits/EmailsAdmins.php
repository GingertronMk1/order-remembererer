<?php

namespace app\Traits;

trait EmailsAdmins
{
    public static function bootEmailsAdmins()
    {
        static::observe(EmailsAdminsOberver::class);
    }
}
