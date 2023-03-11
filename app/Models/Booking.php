<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'court_id',
        'date',
        'hour',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
