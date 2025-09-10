<?php

namespace App\Filament\Resources\Admin\Contracts;

use App\Filament\Resources\Admin\Contracts\Pages\CreateContract;
use App\Filament\Resources\Admin\Contracts\Pages\EditContract;
use App\Filament\Resources\Admin\Contracts\Pages\ListContracts;
use App\Filament\Resources\Admin\Contracts\Pages\ViewContract;
use App\Filament\Resources\Admin\Contracts\Schemas\ContractForm;
use App\Filament\Resources\Admin\Contracts\Schemas\ContractInfolist;
use App\Filament\Resources\Admin\Contracts\Tables\ContractsTable;
use App\Models\Contract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContractResource extends Resource
{
    protected static ?string $slug = 'hop-dong';
    protected static ?string $model = Contract::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Hợp đồng';

    protected static ?string $pluralModelLabel = 'Hợp đồng';

    protected static ?string $recordTitleAttribute = 'contract_number';

    public static function form(Schema $schema): Schema
    {
        return ContractForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContractInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContractsTable::configure($table);
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
            'index' => ListContracts::route('/'),
            'create' => CreateContract::route('/create'),
            'view' => ViewContract::route('/{record}'),
            'edit' => EditContract::route('/{record}/edit'),
        ];
    }
}
