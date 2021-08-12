<?php

namespace App\Models;

use App\Jobs\PurchaseExpiryJob;
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

    public function expire($sync = false)
    {
        if ($sync) {
            PurchaseExpiryJob::dispatchSync($this);
        } else {
            PurchaseExpiryJob::dispatch($this);
        }
    }
}
