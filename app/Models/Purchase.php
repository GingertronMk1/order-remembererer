<?php

namespace App\Models;

use App\Traits\Accountable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Accountable;

    public static function boot() {
        parent::boot();
        static::creating(function($purchase) {
            if(empty($purchase->team_id) && Auth::user() && Auth::user()->currentTeam) {
                $purchase->team_id = Auth::user()->currentTeam->id;
            }
        });
    }

    protected $fillable = [
        'vendor_id',
        'team_id',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
