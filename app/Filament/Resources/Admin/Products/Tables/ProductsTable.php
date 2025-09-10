<?php

namespace App\Filament\Resources\Admin\Products\Tables;

use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Enums\RecordActionsPosition;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Hình ảnh')->imageHeight(40)->circular(),
                TextColumn::make('category.name')->label('Danh mục')->badge()->searchable()->sortable(),
                TextColumn::make('name')->label('Tên sản phẩm')->searchable()->grow(),
                TextColumn::make('unit')->label('Đơn vị tính')->searchable()->sortable(),
                IconColumn::make('active')->label('Hoạt động')->boolean()->sortable(),
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
