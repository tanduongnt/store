<?php

namespace App\Models\Pivot;

use App\Models\Contract;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContractProduct extends Pivot
{
    use HasFactory, Notifiable;

    public $incrementing = true;

    protected $fillable = [
        'product_id',
        'contract_id',
        'price',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
