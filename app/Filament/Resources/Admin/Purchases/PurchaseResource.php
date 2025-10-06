<?php

namespace App\Filament\Resources\Admin\Purchases;

use App\Filament\Resources\Admin\Purchases\Pages\CreatePurchase;
use App\Filament\Resources\Admin\Purchases\Pages\EditPurchase;
use App\Filament\Resources\Admin\Purchases\Pages\ListPurchases;
use App\Filament\Resources\Admin\Purchases\Pages\ViewPurchase;
use App\Filament\Resources\Admin\Purchases\Schemas\PurchaseForm;
use App\Filament\Resources\Admin\Purchases\Schemas\PurchaseInfolist;
use App\Filament\Resources\Admin\Purchases\Tables\PurchasesTable;
use App\Models\Purchase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PurchaseResource extends Resource
{
    protected static ?string $slug = 'mua-hang';
    protected static ?string $model = Purchase::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-shopping-bag';
    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Mua hàng';

    protected static ?string $pluralModelLabel = 'Mua hàng';

    public static function form(Schema $schema): Schema
    {
        return PurchaseForm::configure($schema);
    }

    // public static function infolist(Schema $schema): Schema
    // {
    //     return PurchaseInfolist::configure($schema);
    // }

    public static function table(Table $table): Table
    {
        return PurchasesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPurchases::route('/'),
            'create' => CreatePurchase::route('/create'),
            'view' => ViewPurchase::route('/{record}'),
            'edit' => EditPurchase::route('/{record}/edit'),
        ];
    }
}
