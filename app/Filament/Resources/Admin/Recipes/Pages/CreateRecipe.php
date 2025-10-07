<?php

namespace App\Filament\Resources\Admin\Recipes\Pages;

use App\Filament\Concerns\HasRedirectUrl;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Admin\Recipes\RecipeResource;

class CreateRecipe extends CreateRecord
{
    use HasRedirectUrl;
    protected static string $resource = RecipeResource::class;
}
