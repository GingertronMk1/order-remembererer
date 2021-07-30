<?php

namespace App\Models;

use App\Traits\EmailsAdmins;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;
    use EmailsAdmins;

    protected $fillable = [
        'name',
        'description',
        'address',
        'website',
        'email',
        'phone',
    ];

    public function cuisines()
    {
        return $this->belongsToMany(Cuisine::class);
    }
}
