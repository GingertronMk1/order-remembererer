<?php

namespace App\Models;

use App\Traits\Accountable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvitation extends Model
{
    use HasFactory;
    use Accountable;

    protected $fillable = [
        'purchase_id',
        'user_id',
        'accepted'
    ];

    protected $with = [
        'purchase',
        'user'
    ];

    protected $casts = [
        'accepted' => 'json'
    ];

    protected $attributes = [
        'accepted' => '{}'
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
