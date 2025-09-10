<?php

namespace App\Filament\Resources\Admin\Contracts\Pages;

use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Contracts\ContractResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContract extends CreateRecord
{
    use HasRedirectUrl;
    protected static string $resource = ContractResource::class;
}
