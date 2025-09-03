<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory, Notifiable;
    use HasUuids;

    protected $fillable = [
        'date',
        'code',
        'receiver',
        'position',
        'files',
        'images',
        'description',
        'import',
    ];

    protected $casts = [
        'date'      => 'datetime',
        'files'     => 'array',
        'images'    => 'array',
        'import'    => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity'])->withTimestamps();
    }
}
