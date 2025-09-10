<?php

namespace App\Filament\Resources\Admin\Contracts\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Contracts\ContractResource;

class EditContract extends EditRecord
{
    use HasRedirectUrl;

    protected static string $resource = ContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }
}
