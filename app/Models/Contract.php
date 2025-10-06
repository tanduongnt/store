<?php

namespace App\Models;

use App\Models\Pivot\ContractProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contract extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'supplier_id',
        'contract_number',
        'start_date',
        'end_date',
        'note',
        'files',
    ];

    protected $casts = [
        'start_date'    => 'date',
        'end_date'      => 'date',
        'files'         => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->whereDate('start_date', '<=', today())->whereDate('end_date', '>=', today());
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['price'])->withTimestamps();
    }

    public function contractProducts(): HasMany
    {
        return $this->hasMany(ContractProduct::class);
    }
}
