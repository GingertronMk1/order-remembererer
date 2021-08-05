<?php

namespace App\Models;

use App\Notifications\PurchaseExpiredNotification;
use App\Traits\Accountable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Accountable;

    protected $fillable = [
        'vendor_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'data' => 'json',
    ];

    protected $with = [
        'vendor',
        'user',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
            return $builder->orderBy('expires_at', 'desc');
        });
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invitations()
    {
        return $this->hasMany(PurchaseInvitation::class);
    }

    public function expire()
    {
        $data = [];

        $this->invitations->each(function ($invitation) use (&$data) {
            $user_id = $invitation->user_id;
            $order = Order::where('user_id', $user_id)->where('vendor_id', $this->vendor_id)->first();
            $user = User::find($user_id);
            if ($order) {
                $data[$user_id] = ['name' => $user ? $user->id : 'Error finding user'];
                foreach ([
                    'food',
                    'drink',
                    'other',
                ] as $aspect) {
                    if ($invitation->accepted[$aspect] && $order->{$aspect}) {
                        $data[$user_id][$aspect] = $order->{$aspect};
                    } else {
                        $data[$user_id][$aspect] = 'N/A';
                    }
                }
            }
        });

        $this->data = $data;
        $this->expired = true;
        if ($this->save()) {
            $this->user->notify(new PurchaseExpiredNotification($this));
        }
    }
}
