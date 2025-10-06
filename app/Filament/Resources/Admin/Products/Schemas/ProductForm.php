<?php

namespace App\Filament\Resources\Admin\Products\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('image')->label('Hình ảnh')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('category_id')->label('Danh mục')
                            ->relationship('category', 'name')
                            ->rules(['required'])
                            ->markAsRequired()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\TextInput::make('name')->label('Tên sản phẩm')
                            ->rules(['required'])
                            ->markAsRequired()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('unit')->label('Đơn vị tính (Gốc)')
                            ->rules(['required'])
                            ->markAsRequired(),
                        Forms\Components\TextInput::make('mix_unit')->label('Đơn vị tính pha chế')
                            ->rules(['required'])
                            ->markAsRequired(),
                        Forms\Components\TextInput::make('unit_conversion')->label('Giá trị quy đổi đơn vị tính pha chế')
                            ->rules(['required'])
                            ->markAsRequired(),
                        Forms\Components\Textarea::make('description')->label('Mô tả')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('active')->label('Hoạt động')
                            ->default(true),
                    ])->columns(3)->columnSpanFull(),
            ]);
    }
}
