<?php

namespace App\Models\Pivot;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPurchase extends Pivot
{
    use HasFactory, Notifiable;

    public $incrementing = true;

    protected $fillable = [
        'product_id',
        'purchase_id',
        'quantity',
        'price',
        'total_cost',
        'vat',
        'amount',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
