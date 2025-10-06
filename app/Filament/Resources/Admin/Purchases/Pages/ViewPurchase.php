<?php

namespace App\Filament\Resources\Admin\Purchases\Pages;

use App\Filament\Resources\Admin\Purchases\PurchaseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchase extends ViewRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
