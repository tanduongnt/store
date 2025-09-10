<?php

namespace App\Filament\Resources\Admin\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Tên danh mục')
                    ->rules(['required'])
                    ->markAsRequired()
                    ->columnSpanFull(),
                Textarea::make('description')->label('Mô tả')
                    ->columnSpanFull(),
            ]);
    }
}
