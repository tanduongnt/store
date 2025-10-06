<?php

namespace App\Filament\Resources\Admin\Recipes\Pages;

use App\Filament\Resources\Admin\Recipes\RecipeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRecipe extends ViewRecord
{
    protected static string $resource = RecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
