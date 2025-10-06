<?php

namespace App\Models;

use App\Models\Pivot\ProductPurchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    use HasFactory, Notifiable;
    use HasUuids;

    protected $fillable = [
        'supplier_id',
        'date',
        'invoice_number',
        'code',

        'amount',
        'vat_amount',
        'total_amount',

        'description',

        'receiver',
        'position',

        'attachments',

        'provided',
    ];

    protected $casts = [
        'date'          => 'datetime',
        'attachments'   => 'array',
        'provided'      => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'price', 'total_cost', 'vat', 'amount'])->withTimestamps();
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class)->where('active', true);
    }

    public function productPurchases(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }
}
