<?php

namespace App\Filament\Resources\Admin\Purchases\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PurchaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('supplier.name'),
                TextEntry::make('date')
                    ->dateTime(),
                TextEntry::make('invoice_number'),
                TextEntry::make('code'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('vat_amount')
                    ->numeric(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('receiver'),
                TextEntry::make('position'),
                IconEntry::make('provided')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}