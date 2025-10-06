<?php

namespace App\Filament\Resources\Admin\Purchases\Tables;

use App\Models\Purchase;
use App\Models\Transaction;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;

class PurchasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Ngày mua')->dateTime()->sortable(),
                TextColumn::make('supplier.name')->label('Nhà cung cấp')->badge()->searchable()->sortable()->grow(),
                TextColumn::make('invoice_number')->label('Số hóa đơn')->searchable(),
                TextColumn::make('code')->label('Mã phiếu')->searchable(),
                TextColumn::make('amount')->label('Tổng tiền hàng')->numeric()->sortable(),
                TextColumn::make('vat_amount')->label('Tổng thuế VAT')->numeric()->sortable(),
                TextColumn::make('total_amount')->label('Tổng thanh toán')->numeric()->sortable(),
                TextColumn::make('receiver')->label('Người nhận hàng')->searchable(),
                IconColumn::make('provided')->label('Đã cung cấp hàng hóa')->boolean(),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Ngày cập nhật')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\ActionGroup::make([
                    Actions\ActionGroup::make([
                        ViewAction::make(),
                    ])->dropdown(false),
                    Actions\ActionGroup::make([
                        EditAction::make(),
                    ])->dropdown(false),
                    Actions\ActionGroup::make([
                        Actions\Action::make('transfer')->label('Nhập kho nhanh')
                            ->icon('tabler-transfer-in')
                            ->color('success')
                            ->requiresConfirmation()
                            ->action(function (Purchase $record) {
                                Transaction::create([
                                    'import' => true,
                                    'date' => now(),
                                    'code' => $record->code,
                                    'description' => "Nhập kho nhanh từ phiếu mua hàng {$record->code}",
                                ]);
                            }),
                    ])->dropdown(false),
                    Actions\ActionGroup::make([
                        DeleteAction::make(),
                    ])->dropdown(false),
                ]),
            ], position: RecordActionsPosition::BeforeCells)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
