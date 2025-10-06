<?php

namespace App\Filament\Resources\Admin\Imports\Pages;

use App\Filament\Resources\Admin\Imports\ImportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListImports extends ListRecords
{
    protected static string $resource = ImportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
