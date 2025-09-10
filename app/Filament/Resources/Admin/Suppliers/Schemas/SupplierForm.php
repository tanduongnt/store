<?php

namespace App\Filament\Resources\Admin\Suppliers\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Tên nhà cung cấp')
                            ->rules(['required'])
                            ->markAsRequired(true)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('address')->label('Địa chỉ')
                            ->rules(['required'])
                            ->markAsRequired(true)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('tax')->label('Mã số thuế')
                            ->maxLength(25),
                        Forms\Components\TextInput::make('phone')->label('Số điện thoại')
                            ->rules(['required'])
                            ->markAsRequired(true),
                        Forms\Components\TextInput::make('email')->label('Email'),
                        Forms\Components\Textarea::make('notes')->label('Ghi chú')
                            ->autosize()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('active')->label('Hoạt động')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
