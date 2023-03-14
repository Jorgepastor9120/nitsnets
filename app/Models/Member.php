<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Member",
 *     description="Member model",
 *     @OA\Property(
 *         property="id",
 *         type="integer(20)",
 *         description="ID",
 *         example="1"
 *     )),
 *     @OA\Property(
 *         property="name",
 *         type="string(255)",
 *         description="name",
 *         example="Prueba"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string(255)",
 *         description="email",
 *         example="prueba@gmail.com"
 *
 * )
 */

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
