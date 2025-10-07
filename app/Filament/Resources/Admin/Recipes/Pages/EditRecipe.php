<?php

namespace App\Filament\Resources\Admin\Recipes\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Recipes\RecipeResource;

class EditRecipe extends EditRecord
{
    use HasRedirectUrl;
    protected static string $resource = RecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
