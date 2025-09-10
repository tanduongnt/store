<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;

class MoneyInput extends TextInput
{
    protected function setUp(): void
    {
        $this->mask(RawJs::make('$money($input, `,`, `.`, 3)'));
        $this->stripCharacters('.');
        $this->formatStateUsing(fn($state) => ($state == '') ? '' : str_replace('.', ',', $state));
        $this->mutateStateForValidationUsing(fn($state) => str_replace(',', '.', $state));
        $this->mutateDehydratedStateUsing(fn($state) => str_replace(',', '.', $state));
        // $this->minValue(0);
        $this->extraInputAttributes([
            'step' => 'any',
            'inputmode' => 'decimal',
        ]);
    }
}
