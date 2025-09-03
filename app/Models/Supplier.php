<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'image',
        'name',
        'code',
        'tax',
        'address',
        'phone',
        'email',
        'notes',
        'attachments',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
        ];
    }

    // Hợp đồng mua vật tư
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
