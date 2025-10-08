<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
