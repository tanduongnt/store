<?php

namespace App\Filament\Resources\Admin\Contracts\Schemas;

use Filament\Forms;
use App\Models\Product;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Components\Forms\MoneyInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('supplier_id')->label('Nhà cung cấp')
                            ->rules(['required'])
                            ->markAsRequired()
                            ->relationship(name: 'supplier', titleAttribute: 'name', modifyQueryUsing: fn(Builder $query) => $query->where('active', true))
                            ->searchable()
                            ->preload(false)
                            ->native(false)
                            ->columnSpanFull()
                            ->extraFieldWrapperAttributes(['tour' => 'contract_supplier_id']),
                        Forms\Components\DatePicker::make('start_date')->label('Từ ngày')
                            ->rules(['required'])
                            ->markAsRequired()
                            ->displayFormat('d-m-Y')
                            ->live()
                            ->default(now())
                            ->seconds(false)
                            ->native(false)
                            ->extraFieldWrapperAttributes(['tour' => 'contract_start_date']),
                        Forms\Components\DatePicker::make('end_date')->label('Đến ngày')
                            ->rules(['required'])
                            ->markAsRequired()
                            ->displayFormat('d-m-Y')
                            ->default(now())
                            ->seconds(false)
                            ->native(false)
                            ->extraFieldWrapperAttributes(['tour' => 'contract_end_date']),
                        Forms\Components\TextInput::make('contract_number')->label('Số hợp đồng')
                            ->columnSpanFull()
                            ->extraFieldWrapperAttributes(['tour' => 'contract_number']),
                        Forms\Components\Textarea::make('note')->label('Ghi chú')
                            ->rows(3)
                            ->columnSpanFull()
                            ->extraFieldWrapperAttributes(['tour' => 'contract_note']),
                        Forms\Components\FileUpload::make('files')->label('Tệp đính kèm')
                            ->multiple()
                            ->openable()
                            ->downloadable()
                            ->previewable(false)
                            ->disk('public')
                            ->directory(fn($record) => 'uploads/asset/contracts/files' . now()->toDateString())
                            ->acceptedFileTypes(['image/*', 'video/*', 'application/pdf'])
                            ->columnSpanFull()
                            ->extraFieldWrapperAttributes(['tour' => 'contract_files']),
                    ])->columns(2)->columnSpanFull(),

                Section::make()
                    ->schema([
                        Forms\Components\Repeater::make('contractProducts')->label('Danh sách sản phẩm')
                            ->relationship()
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                $product = Product::find($data['product_id']);
                                $data['unit'] = $product?->unit;
                                return $data;
                            })
                            ->table([
                                TableColumn::make('Tên sản phẩm')->alignment(Alignment::Start),
                                TableColumn::make('Đơn vị tính')->alignment(Alignment::Start)->width('120px'),
                                TableColumn::make('Giá')->alignment(Alignment::Start)->width('120px'),
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
                                MoneyInput::make('price')
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->extraInputAttributes(['class' => 'text-end']),
                            ])
                            ->addActionLabel('Thêm sản phẩm')
                    ])->columnSpanFull(),
            ]);
    }
}
