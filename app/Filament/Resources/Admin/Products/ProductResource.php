<?php

namespace App\Filament\Resources\Admin\Products;

use App\Filament\Resources\Admin\Products\Pages\CreateProduct;
use App\Filament\Resources\Admin\Products\Pages\EditProduct;
use App\Filament\Resources\Admin\Products\Pages\ListProducts;
use App\Filament\Resources\Admin\Products\Pages\ViewProduct;
use App\Filament\Resources\Admin\Products\Schemas\ProductForm;
use App\Filament\Resources\Admin\Products\Schemas\ProductInfolist;
use App\Filament\Resources\Admin\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $slug = 'san-pham';
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-box';

    protected static ?string $modelLabel = 'Sản phẩm';

    protected static ?string $pluralModelLabel = 'Sản phẩm';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
