<?php

namespace App\Filament\Resources\Admin\Purchases\Schemas;

use Filament\Forms;
use App\Models\Product;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Awcodes\Shout\Components\Shout;
use App\Filament\Schemas\OrderHepler;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Filament\Components\Forms\MoneyInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater\TableColumn;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\DateTimePicker::make('date')->label('Ngày mua')
                    ->rules(['required'])
                    ->markAsRequired()
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->native(false),
                Forms\Components\TextInput::make('invoice_number')->label('Số hóa đơn'),
                Forms\Components\Select::make('supplier_id')->label('Nhà cung cấp')
                    ->rules(['required'])
                    ->markAsRequired()
                    ->relationship('supplier', 'name')
                    ->live()
                    ->native(false),
                Forms\Components\TextInput::make('receiver')->label('Người nhận'),
                Forms\Components\Textarea::make('description')->label('Mô tả')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('attachments')->label('Tệp đính kèm')
                    ->required()
                    ->multiple()
                    ->openable()
                    ->downloadable()
                    ->previewable(false)
                    ->disk('public')
                    ->directory(fn($record) => 'uploads/admin/purchases/attachments/' . now()->toDateString())
                    ->acceptedFileTypes(['image/*', 'video/*', 'application/pdf'])
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('provided')->label('Đã cung cấp hàng hóa')
                    ->default(false)
                    ->columnSpanFull(),

                Section::make()
                    ->schema([
                        Forms\Components\Repeater::make('chi_tiet')->label('Danh sách sản phẩm')
                            ->relationship('productPurchases')
                            ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                                $product = Product::find($data['product_id']);
                                $data['unit'] = $product?->unit;
                                return $data;
                            })
                            ->table([
                                TableColumn::make('Tên sản phẩm')->alignment(Alignment::Start),
                                TableColumn::make('Đơn vị tính')->alignment(Alignment::Start)->width('120px'),
                                TableColumn::make('Số lượng')->alignment(Alignment::End)->width('90px'),
                                TableColumn::make('Giá')->alignment(Alignment::End)->width('120px'),
                                TableColumn::make('Vat')->alignment(Alignment::End)->width('90px'),
                                TableColumn::make('Thành tiền')->alignment(Alignment::End)->width('120px'),
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
                                            $price = $product->contracts()?->where('supplier_id', $get('../../supplier_id'))
                                                ->whereDate('start_date', '<=', today())
                                                ->whereDate('end_date', '>=', today())
                                                ->latest('start_date')
                                                ->first()?->pivot?->price;

                                            $set(('unit'), $product?->unit);
                                            $set('price', number_format($price, 0, ',', '.'));
                                            $set('block', false);

                                            OrderHepler::calculate($get, $set, 1, $price, $get('vat'));
                                            if ($price) {
                                                $set('block', true);
                                            }
                                        }
                                    })
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->native(false),
                                Forms\Components\TextInput::make('unit')->readonly(),
                                MoneyInput::make('quantity')->label('Số lượng')->hiddenLabel()
                                    ->rules(['required', 'gt:0'])
                                    ->markAsRequired(true)
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                        if ($state != null) {
                                            OrderHepler::calculate($get, $set, $state, $get('price'), $get('vat'));
                                        }
                                    })
                                    ->default(1)
                                    ->extraInputAttributes(['class' => 'text-end']),
                                MoneyInput::make('price')
                                    ->rules(['required'])
                                    ->rules(['required'])
                                    ->markAsRequired()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                        if ($state != null) {
                                            OrderHepler::calculate($get, $set, $get('quantity'), $state, $get('vat'));
                                        }
                                    })
                                    ->extraInputAttributes(['class' => 'text-end'])
                                    ->readOnly(fn(Get $get) => $get('block')),
                                MoneyInput::make('vat')->label('VAT')->hiddenLabel()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                        if ($state != null) {
                                            OrderHepler::calculate($get, $set, $get('quantity'), $get('price'), $state);
                                        }
                                    })
                                    ->default(0)
                                    ->minValue(0)
                                    ->extraInputAttributes(['class' => 'text-end']),
                                MoneyInput::make('amount')->label('Thành tiền')->hiddenLabel()->readonly()
                                    ->extraInputAttributes(['class' => 'text-end']),
                                Forms\Components\Hidden::make('total_cost')->default(0),
                                Forms\Components\Hidden::make('vat_price')->default(0)
                            ])
                            ->addActionLabel('Thêm sản phẩm'),
                        Grid::make()
                            ->schema([
                                Forms\Components\Hidden::make('amount')->label('Tổng tiền hàng'),
                                Forms\Components\Hidden::make('vat_amount')->label('Tiền thuế GTGT (VAT)'),
                                Forms\Components\Hidden::make('total_amount')->label('Tổng tiền'),
                                Shout::make('so-important')
                                    ->content(function (Get $get) {
                                        $tong_tien_hang = $get('amount') ?? 0;
                                        $tong_tien_vat = $get('vat_amount') ?? 0;
                                        $tong_tien = $get('total_amount') ?? 0;

                                        return new HtmlString("
                                                <div class='grid justify-end justify-items-end gap-2'>
                                                    <div>Tổng tiền hàng: <span class='font-bold text-red-500'>{$tong_tien_hang}</span></div>
                                                    <div>Tiền thuế GTGT (VAT): <span class='font-bold text-red-500'>{$tong_tien_vat}</span></div>
                                                    <div>Tổng tiền: <span class='font-bold text-red-500'>{$tong_tien}</span></div>
                                                </div>");
                                    })
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->hidden(fn(Get $get) => !$get('supplier_id'))
                    ->columnSpanFull(),

            ]);
    }
}
