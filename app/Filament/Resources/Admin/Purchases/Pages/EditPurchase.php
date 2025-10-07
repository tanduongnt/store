<?php

namespace App\Filament\Resources\Admin\Purchases\Pages;

use Illuminate\Support\Str;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Concerns\HasRedirectUrl;
use App\Filament\Resources\Admin\Purchases\PurchaseResource;

class EditPurchase extends EditRecord
{
    use HasRedirectUrl;
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            // DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['amount'] = number_format($data['amount'], 0, ',', '.');
        $data['vat_amount'] = number_format($data['vat_amount'], 0, ',', '.');
        $data['total_amount'] = number_format($data['total_amount'], 0, ',', '.');
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['amount'] = floatval(Str::of($data['amount'])->replace('.', '')->replace(',', '.')->value);
        $data['vat_amount'] =  floatval(Str::of($data['vat_amount'])->replace('.', '')->replace(',', '.')->value);
        $data['total_amount'] = floatval(Str::of($data['total_amount'])->replace('.', '')->replace(',', '.')->value);

        return $data;
    }
}
