<?php

namespace App\Filament\Resources\Admin\Categories\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Categories\CategoryResource;

class EditCategory extends EditRecord
{
    use HasRedirectUrl;
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
