<?php

namespace App\Filament\Resources\Admin\Imports;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Admin\Imports\Pages\EditImport;
use App\Filament\Resources\Admin\Imports\Pages\ViewImport;
use App\Filament\Resources\Admin\Imports\Pages\ListImports;
use App\Filament\Resources\Admin\Imports\Pages\CreateImport;
use App\Filament\Resources\Admin\Imports\Schemas\ImportForm;
use App\Filament\Resources\Admin\Imports\Tables\ImportsTable;
use App\Filament\Resources\Admin\Imports\Schemas\ImportInfolist;

class ImportResource extends Resource
{
    protected static ?string $slug = 'nhap-kho';
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-transfer-in';
    protected static ?int $navigationSort = 7;

    protected static ?string $modelLabel = 'Nhập kho';

    protected static ?string $pluralModelLabel = 'Nhập kho';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('import', true);
    }

    public static function form(Schema $schema): Schema
    {
        return ImportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImportsTable::configure($table);
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
            'index' => ListImports::route('/'),
            'create' => CreateImport::route('/create'),
            'view' => ViewImport::route('/{record}'),
            'edit' => EditImport::route('/{record}/edit'),
        ];
    }
}
