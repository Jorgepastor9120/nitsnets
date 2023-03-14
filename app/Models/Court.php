<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Court",
 *     description="Court model",
 *     @OA\Property(
 *         property="id",
 *         type="integer(20)",
 *         description="ID",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="sport_id",
 *         type="integer(20)",
 *         description="sport_id",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string(255)",
 *         description="name",
 *         example="Pista 1"
 *     )
 * )
 */

class Court extends Model
{
    use HasFactory;

    protected $casts = [
        'sport_id' => 'int',
        'name' => 'string:255',
    ];

    protected $fillable = [
        'sport_id',
        'name',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
