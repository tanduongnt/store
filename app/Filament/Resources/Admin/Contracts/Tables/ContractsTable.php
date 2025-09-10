<?php

namespace App\Filament\Resources\Admin\Contracts\Tables;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;

class ContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')->rowIndex()->width('40px'),
                Tables\Columns\TextColumn::make('supplier.name')->label('Nhà cung cấp')->badge()->searchable()->sortable()->grow(),
                Tables\Columns\TextColumn::make('contract_number')->label('Số HĐ')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label('Từ ngày')->date()->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('Đến ngày')->date()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
