<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
