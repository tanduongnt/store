<?php

namespace App\Filament\Resources\Admin\Recipes;

use App\Filament\Resources\Admin\Recipes\Pages\CreateRecipe;
use App\Filament\Resources\Admin\Recipes\Pages\EditRecipe;
use App\Filament\Resources\Admin\Recipes\Pages\ListRecipes;
use App\Filament\Resources\Admin\Recipes\Pages\ViewRecipe;
use App\Filament\Resources\Admin\Recipes\Schemas\RecipeForm;
use App\Filament\Resources\Admin\Recipes\Schemas\RecipeInfolist;
use App\Filament\Resources\Admin\Recipes\Tables\RecipesTable;
use App\Models\Recipe;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RecipeResource extends Resource
{
    protected static ?string $slug = 'pha-che';
    protected static ?string $model = Recipe::class;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-coffee';
    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Pha chế';

    protected static ?string $pluralModelLabel = 'Pha chế';

    protected static ?string $recordTitleAttribute = 'contract_number';

    public static function form(Schema $schema): Schema
    {
        return RecipeForm::configure($schema);
    }

    // public static function infolist(Schema $schema): Schema
    // {
    //     return RecipeInfolist::configure($schema);
    // }

    public static function table(Table $table): Table
    {
        return RecipesTable::configure($table);
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
            'index' => ListRecipes::route('/'),
            'create' => CreateRecipe::route('/create'),
            'view' => ViewRecipe::route('/{record}'),
            'edit' => EditRecipe::route('/{record}/edit'),
        ];
    }
}
