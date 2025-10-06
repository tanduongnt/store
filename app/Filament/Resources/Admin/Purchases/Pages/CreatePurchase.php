<?php

namespace App\Filament\Resources\Admin\Purchases\Pages;

use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Admin\Purchases\PurchaseResource;
use App\Models\Purchase;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = static::generateCodeNumber();
        $data['amount'] = floatval(Str::of($data['amount'])->replace('.', '')->replace(',', '.')->value);
        $data['vat_amount'] = floatval(Str::of($data['vat_amount'])->replace('.', '')->replace(',', '.')->value);
        $data['total_amount'] = floatval(Str::of($data['total_amount'])->replace('.', '')->replace(',', '.')->value);
        return $data;
    }

    private static function generateCodeNumber(): string
    {
        $date = now();
        $count = Purchase::query()
            ->whereYear('date', $date->format('Y'))
            ->whereMonth('date', $date->format('m'))
            ->count() + 1;
        $count = Str::padLeft($count, 3, '0');

        return "{$date->format('Ym')}-{$count}";
    }
}
