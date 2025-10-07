<?php

namespace App\Filament\Resources\Admin\Exports\Pages;

use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Filament\Concerns\HasRedirectUrl;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Admin\Exports\ExportResource;

class CreateExport extends CreateRecord
{
    use HasRedirectUrl;
    protected static string $resource = ExportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['import'] = false;
        $data['code'] = static::generateCodeNumber();
        return $data;
    }

    private static function generateCodeNumber(): string
    {
        $date = now();
        $count = Transaction::query()
            ->whereYear('date', $date->format('Y'))
            ->whereMonth('date', $date->format('m'))
            ->count() + 1;
        $count = Str::padLeft($count, 3, '0');

        return "{$date->format('Ym')}-{$count}";
    }
}
