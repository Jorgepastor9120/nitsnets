<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Sport",
 *     description="Sport model",
 *     @OA\Property(
 *         property="id",
 *         type="integer(20)",
 *         description="ID",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string(255)",
 *         description="Nombre",
 *         example="Tenis"
 *     )
 * )
 */

class Sport extends Model
{
    use HasFactory;

    protected $casts = [
        'name' => 'string:255',
    ];
    
    protected $fillable = [
        'name'
    ];

    public function courts()
    {
        return $this->hasMany(Court::class);
    }
}
