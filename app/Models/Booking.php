<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Booking",
 *     description="Booking model",
 *     @OA\Property(
 *         property="id",
 *         type="integer(20)",
 *         description="ID",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="member_id",
 *         type="integer(20)",
 *         description="member_id",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="court_id",
 *         type="integer(20)",
 *         description="court_id",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="integer(20)",
 *         description="date",
 *         example="2023-02-23"
 *     ),
 *     @OA\Property(
 *         property="hour_reserve_id",
 *         type="integer(20)",
 *         description="hour_reserve_id",
 *         example="1"
 *     )
 * )
 */

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
