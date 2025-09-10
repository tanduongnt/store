<?php

namespace App\Filament\Concerns;

trait HasRedirectUrl
{
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getResource()::getUrl('index');
    }
}
