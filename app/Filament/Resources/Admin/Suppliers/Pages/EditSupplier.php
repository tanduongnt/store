<?php

namespace App\Filament\Resources\Admin\Suppliers\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Suppliers\SupplierResource;

class EditSupplier extends EditRecord
{
    use HasRedirectUrl;
    protected static string $resource = SupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
