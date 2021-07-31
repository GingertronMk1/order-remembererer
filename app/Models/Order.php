<?php

namespace App\Models;

use App\Traits\Accountable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Accountable;

    protected $fillable = [
        'food',
        'drink',
        'other',
        'vendor_id',
    ];

    protected $with = [
        'user',
        'vendor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
