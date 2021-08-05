<?php

namespace App\Models;

use App\Notifications\PurchaseInvitationNotification;
use App\Traits\Accountable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PurchaseInvitation extends Model
{
    use HasFactory;
    use Accountable;
    use Notifiable;

    protected $fillable = [
        'purchase_id',
        'user_id',
        'accepted',
    ];

    protected $with = [
        'purchase',
        'user',
    ];

    protected $casts = [
        'accepted' => 'json',
    ];

    protected $attributes = [
        'accepted' => '{}',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($invitation) {
            $invitation->token = \Illuminate\Support\Str::uuid();
        });

        static::created(function ($invitation) {
            $invitation->user->notify(new PurchaseInvitationNotification($invitation));
        });
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
