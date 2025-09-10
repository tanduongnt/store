<?php

namespace App\Filament\Resources\Admin\Suppliers\Tables;

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

class SuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')->rowIndex()->width('40px'),
                Tables\Columns\TextColumn::make('name')->label('Tên nhà cung cấp')->searchable()->sortable()->grow(),
                Tables\Columns\TextColumn::make('address')->label('Địa chỉ')->searchable()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('phone')->label('Số điện thoại')->searchable(),
                Tables\Columns\TextColumn::make('tax')->label('Mã số thuế')->limit(25)->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\IconColumn::make('active')->label('Hoạt động')->boolean()->sortable()->toggleable()->width('80px')->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')->label('Ngày tạo')->datetime('d-m-Y H:i')->sortable()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('updated_at')->label('Ngày cập nhật')->datetime('d-m-Y H:i')->sortable()->toggleable()->toggledHiddenByDefault(),
            ])
            ->recordUrl(null)
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
