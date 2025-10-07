<?php

namespace App\Filament\Resources\Admin\Exports\Tables;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Enums\RecordActionsPosition;

class ExportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')->rowIndex()->width('40px')->width('40px'),
                Tables\Columns\TextColumn::make('date')->label('Ngày xuất kho')->date('d-m-Y H:i')->searchable()->sortable()->width('120px'),
                Tables\Columns\TextColumn::make('code')->label('Mã xuất kho')->searchable()->sortable()->width('120px'),
                Tables\Columns\TextColumn::make('description')->label('Mô tả')->limit(50)->searchable(),
                Tables\Columns\TextColumn::make('receiver')->label('Người xuất kho')->searchable()->sortable()->width('120px'),
                Tables\Columns\TextColumn::make('created_at')->label('Ngày tạo')->datetime('d-m-Y H:i')->sortable()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('updated_at')->label('Ngày cập nhật')->datetime('d-m-Y H:i')->sortable()->toggleable()->toggledHiddenByDefault(),
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
