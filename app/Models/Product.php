<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, Notifiable;
    use HasSlug;

    protected $fillable = [
        'category_id',
        'image',
        'name',
        'slug',
        'unit',
        'mix_unit',
        'unit_conversion',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class)->withPivot(['price'])->withTimestamps();
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)->withPivot(['quantity'])->withTimestamps();
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->withPivot(['quantity'])->withTimestamps();
    }
}
