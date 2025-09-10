<?php

namespace App\Filament\Resources\Admin\Categories\Pages;

use App\Filament\Concerns\HasRedirectUrl;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Admin\Categories\CategoryResource;

class CreateCategory extends CreateRecord
{
    use HasRedirectUrl;

    protected static string $resource = CategoryResource::class;
}