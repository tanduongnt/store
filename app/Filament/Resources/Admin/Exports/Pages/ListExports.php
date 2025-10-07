<?php

namespace App\Filament\Resources\Admin\Exports\Pages;

use App\Filament\Resources\Admin\Exports\ExportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExports extends ListRecords
{
    protected static string $resource = ExportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
