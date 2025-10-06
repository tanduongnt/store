<?php

namespace App\Filament\Resources\Admin\Imports\Pages;

use App\Filament\Resources\Admin\Imports\ImportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImport extends ViewRecord
{
    protected static string $resource = ImportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
