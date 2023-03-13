<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $casts = [
        'name' => 'string:255',
        'email' => 'string:255',
    ];

    protected $fillable = [
        'name',
        'email',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
