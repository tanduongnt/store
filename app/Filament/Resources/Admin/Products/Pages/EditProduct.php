<?php

namespace App\Filament\Resources\Admin\Products\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Products\ProductResource;

class EditProduct extends EditRecord
{
    use HasRedirectUrl;
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
