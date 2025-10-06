<?php

namespace App\Models\Pivot;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRecipe extends Pivot
{
    use HasFactory, Notifiable;

    public $incrementing = true;

    protected $fillable = [
        'product_id',
        'contract_id',
        'quantity',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
