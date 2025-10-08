<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum BlockStatus: string implements HasLabel
{
    case Available = 'available';
    case Recerved = 'recerved';
    case Occupied = 'occupied';
    case Ordering = 'ordering';
    case Unavailable = 'unavailable';

    public function getLabel(): string
    {
        return match ($this) {
            self::Available => 'Bàn trống',
            self::Recerved => 'Bàn đã đặt trước',
            self::Occupied => 'Bàn đang có khách',
            self::Ordering => 'Bàn đã phục vụ',
            self::Unavailable => 'Bàn đang bị hỏng',
        };
    }

    // public function getColor(): ?string
    // {
    //     return match ($this) {
    //     };
    // }

    // public function getIcon(): ?string
    // {
    //     return match ($this) {
    //     };
    // }
}
