<?php

namespace App\Filament\Resources\Admin\Imports\Pages;

use App\Filament\Resources\Admin\Imports\ImportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImport extends CreateRecord
{
    protected static string $resource = ImportResource::class;
}
