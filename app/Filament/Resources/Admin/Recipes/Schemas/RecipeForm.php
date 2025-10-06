<?php

namespace App\Filament\Resources\Admin\Recipes\Schemas;

use Filament\Forms;
use App\Models\Product;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Schemas\Components\Section;
use App\Filament\Components\Forms\MoneyInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class RecipeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\FileUpload::make('image')->label('Hình ảnh')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')->label('Tên công thức')
                    ->rules(['required'])
                    ->markAsRequired()
                    ->columnSpanFull(),
                MoneyInput::make('price')->label('Giá bán')
                    ->rules(['required', 'numeric'])
                    ->markAsRequired()
                    ->default(0),
                MoneyInput::make('discount_price')->label('Giá khuyến mãi')
                    ->rules(['required', 'numeric'])
                    ->markAsRequired()
                    ->default(0),
                Forms\Components\Textarea::make('description')->label('Mô tả')
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Forms\Components\Repeater::make('productRecipes')->label('Nguyên liệu')
                            ->relationship()
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                $product = Product::find($data['product_id']);
                                $data['unit'] = $product?->mix_unit;
                                return $data;
                            })
                            ->table([
                                TableColumn::make('Tên sản phẩm')->alignment(Alignment::Start),
                                TableColumn::make('Đơn vị tính')->alignment(Alignment::Start)->width('120px'),
                                TableColumn::make('Số lượng')->alignment(Alignment::Start)->width('120px'),
                            ])
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->options(fn() => Product::orderBy('name')->pluck('name', 'id'))
                                    ->live()
                                    ->afterStateUpdated(function (?string $state, ?string $old, Get $get, Set $set) {
                                        $set(('unit'), null);
                                        if ($state) {
                                            $product = Product::find($state);
                                            $set(('unit'), $product?->mix_unit);
                                        }
                                    })
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->native(false),
                                Forms\Components\TextInput::make('unit')->readonly(),
                                MoneyInput::make('quantity')
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->extraInputAttributes(['class' => 'text-end']),
                            ])
                            ->addActionLabel('Thêm sản phẩm')
                    ])->columnSpanFull(),
            ]);
    }
}
