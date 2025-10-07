<?php

namespace App\Filament\Resources\Admin\Exports\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Exports\ExportResource;

class EditExport extends EditRecord
{
    use HasRedirectUrl;
    protected static string $resource = ExportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
