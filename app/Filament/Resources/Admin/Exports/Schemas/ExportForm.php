<?php

namespace App\Filament\Resources\Admin\Exports\Schemas;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Support\Enums\Alignment;
use App\Models\Pivot\ProductTransaction;
use Filament\Schemas\Components\Section;
use App\Filament\Components\Forms\MoneyInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class ExportForm
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
                Forms\Components\TextInput::make('receiver')->label('Người xuất kho')
                    ->rules(['required'])
                    ->markAsRequired(true),
                Forms\Components\Textarea::make('description')->label('Mô tả')
                    ->rules(['required'])
                    ->markAsRequired(true)
                    ->autoSize()
                    ->columnSpanFull(),
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
                                MoneyInput::make('quantity')->label('Số lượng')
                                    ->rules(['required', 'numeric', 'gt:0'])
                                    ->markAsRequired()
                                    ->maxValue(function (Get $get, $record) {
                                        $product_id = $get('product_id');

                                        $totalQuantity = ProductTransaction::query()
                                            ->join('transactions', 'product_transaction.transaction_id', '=', 'transactions.id')
                                            ->where('product_transaction.product_id', $product_id)
                                            ->where('product_transaction.id', '!=', $record?->id)
                                            ->whereDate('transactions.date', '<=', Carbon::parse($get('../../date')))
                                            ->groupBy('transactions.import')
                                            ->select('transactions.import', DB::raw('SUM(COALESCE(product_transaction.quantity, 0)) as total_quantity'))
                                            ->pluck('total_quantity', 'import')->toArray();
                                        $totalQuantityImport = $totalQuantity[1] ?? 0;
                                        $totalQuantityExport = $totalQuantity[0] ?? 0;

                                        return  $totalQuantityImport - $totalQuantityExport;
                                    })
                                    ->validationMessages([
                                        'max' => ':Attribute tối đa là :max',
                                    ])
                                    ->extraInputAttributes(['class' => 'text-end']),
                            ])
                            ->addActionLabel('Thêm sản phẩm')
                    ])->columnSpanFull(),
            ]);
    }
}
