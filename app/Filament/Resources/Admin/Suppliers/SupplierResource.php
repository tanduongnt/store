<?php

namespace App\Filament\Resources\Admin\Suppliers;

use App\Filament\Resources\Admin\Suppliers\Pages\CreateSupplier;
use App\Filament\Resources\Admin\Suppliers\Pages\EditSupplier;
use App\Filament\Resources\Admin\Suppliers\Pages\ListSuppliers;
use App\Filament\Resources\Admin\Suppliers\Pages\ViewSupplier;
use App\Filament\Resources\Admin\Suppliers\Schemas\SupplierForm;
use App\Filament\Resources\Admin\Suppliers\Schemas\SupplierInfolist;
use App\Filament\Resources\Admin\Suppliers\Tables\SuppliersTable;
use App\Models\Supplier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $slug = 'nha-cung-cap';
    protected static ?string $model = Supplier::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-building-store';
    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Nhà cung cấp';

    protected static ?string $pluralModelLabel = 'Nhà cung cấp';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SupplierForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SupplierInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuppliersTable::configure($table);
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
            'index' => ListSuppliers::route('/'),
            'create' => CreateSupplier::route('/create'),
            'view' => ViewSupplier::route('/{record}'),
            'edit' => EditSupplier::route('/{record}/edit'),
        ];
    }
}
