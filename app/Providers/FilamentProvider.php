<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Resources;
use Filament\Actions;
use Filament\Tables;

class FilamentProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Resources\Pages\CreateRecord::disableCreateAnother();

        Actions\ActionGroup::configureUsing(function (Actions\ActionGroup $group): void {
            $group->dropdownPlacement('bottom-start');
        });

        Tables\Table::configureUsing(function (Tables\Table $table): void {
            $table->defaultDateDisplayFormat('d-m-Y');
            $table->defaultDateTimeDisplayFormat('d-m-Y H:i');
            $table->defaultTimeDisplayFormat('H:i:s');
        });
    }
}
