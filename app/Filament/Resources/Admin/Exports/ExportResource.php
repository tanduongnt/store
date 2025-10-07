<?php

namespace App\Filament\Resources\Admin\Exports;

use BackedEnum;
use App\Models\Export;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Admin\Exports\Pages\EditExport;
use App\Filament\Resources\Admin\Exports\Pages\ViewExport;
use App\Filament\Resources\Admin\Exports\Pages\ListExports;
use App\Filament\Resources\Admin\Exports\Pages\CreateExport;
use App\Filament\Resources\Admin\Exports\Schemas\ExportForm;
use App\Filament\Resources\Admin\Exports\Tables\ExportsTable;
use App\Filament\Resources\Admin\Exports\Schemas\ExportInfolist;

class ExportResource extends Resource
{
    protected static ?string $slug = 'xuat-kho';
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-transfer-out';

    protected static ?int $navigationSort = 8;

    protected static ?string $modelLabel = 'Xuất kho';

    protected static ?string $pluralModelLabel = 'Xuất kho';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('import', false);
    }

    public static function form(Schema $schema): Schema
    {
        return ExportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExportsTable::configure($table);
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
            'index' => ListExports::route('/'),
            'create' => CreateExport::route('/create'),
            'view' => ViewExport::route('/{record}'),
            'edit' => EditExport::route('/{record}/edit'),
        ];
    }
}
