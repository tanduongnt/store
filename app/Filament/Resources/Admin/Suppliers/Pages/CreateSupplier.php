<?php

namespace App\Filament\Resources\Admin\Suppliers\Pages;

use App\Filament\Concerns\HasRedirectUrl;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Admin\Suppliers\SupplierResource;

class CreateSupplier extends CreateRecord
{
    use HasRedirectUrl;
    protected static string $resource = SupplierResource::class;
}
