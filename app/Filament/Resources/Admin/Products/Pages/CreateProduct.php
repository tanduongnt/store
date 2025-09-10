<?php

namespace App\Filament\Resources\Admin\Products\Pages;

use App\Filament\Concerns\HasRedirectUrl;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Admin\Products\ProductResource;

class CreateProduct extends CreateRecord
{
    use HasRedirectUrl;
    protected static string $resource = ProductResource::class;
}
