<?php

namespace App\Filament\Resources\Admin\Imports\Schemas;

use Filament\Forms;
use App\Models\Product;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use App\Filament\Components\Forms\MoneyInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class ImportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\DateTimePicker::make('date')->label('Ngày nhập kho')
                    ->rules(['required'])
                    ->markAsRequired()
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->native(false),
                Forms\Components\Textarea::make('description')->label('Mô tả')
                    ->rules(['required'])
                    ->markAsRequired(true)
                    ->autoSize()
                    ->columnSpanFull()
                    ->extraFieldWrapperAttributes(['tour' => 'import_description']),
                Forms\Components\FileUpload::make('files')->label('Tệp đính kèm')
                    ->multiple()
                    ->openable()
                    ->downloadable()
                    ->previewable(false)
                    ->disk('public')
                    ->directory(fn($record) => 'uploads/transaction/imports/files/' . now()->toDateString())
                    ->acceptedFileTypes(['image/*', 'video/*', 'application/pdf'])
                    ->extraFieldWrapperAttributes(['tour' => 'import_files']),
                Forms\Components\FileUpload::make('images')->label('Hình ảnh')
                    ->multiple()
                    ->panelLayout('grid')
                    ->openable()
                    ->downloadable()
                    ->previewable(true)
                    ->disk('public')
                    ->directory(fn($record) => 'uploads/transaction/imports/images/' . now()->toDateString())
                    ->acceptedFileTypes(['image/*', 'video/*'])
                    ->extraFieldWrapperAttributes(['tour' => 'import_images']),

                Section::make()
                    ->schema([
                        Forms\Components\Repeater::make('productTransactions')->label('Danh sách sản phẩm')
                            ->relationship()
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                $product = Product::find($data['product_id']);
                                $data['unit'] = $product?->unit;
                                return $data;
                            })
                            ->table([
                                TableColumn::make('Tên sản phẩm')->alignment(Alignment::Start),
                                TableColumn::make('Đơn vị tính')->alignment(Alignment::Start)->width('120px'),
                                TableColumn::make('Số lượng')->alignment(Alignment::Start)->width('120px'),
                            ])
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->options(fn() => Product::orderBy('name')->pluck('name', 'id'))
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->live()
                                    ->afterStateUpdated(function (?string $state, ?string $old, Get $get, Set $set) {
                                        $set(('unit'), null);
                                        if ($state) {
                                            $product = Product::find($state);
                                            $set(('unit'), $product?->unit);
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
