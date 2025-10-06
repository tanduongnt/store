<?php

namespace App\Filament\Resources\Admin\Recipes\Tables;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Enums\RecordActionsPosition;

class RecipesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')->rowIndex()->width('40px'),
                Tables\Columns\ImageColumn::make('image')->label('Hình ảnh')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Tên công thức')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Giá bán')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('discount_price')->label('Giá khuyến mãi')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Ngày tạo')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Ngày cập nhật')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
