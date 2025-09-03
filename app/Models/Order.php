<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, Notifiable;
    use HasUuids;

    protected $fillable = [
        'status',
        'total',
        'payment_status',
        'payment_method',
        'user_id',
    ];

    protected $casts = [];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
