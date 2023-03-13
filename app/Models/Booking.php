<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
        'member_id' => 'int',
        'court_id' => 'int',
        'date' => 'date',
        'hour_reserve_id' => 'string:5',
    ];

    protected $fillable = [
        'member_id',
        'court_id',
        'date',
        'hour_reserve_id',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function hourReserve()
    {
        return $this->belongsTo(HourReserve::class);
    }
}
