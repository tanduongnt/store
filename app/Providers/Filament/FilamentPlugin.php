<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use Filament\FontProviders\BunnyFontProvider;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Vite;

class FilamentPlugin
{
    public static function useCommonSetting(Panel $panel): Panel
    {
        return $panel
            ->login()
            ->authGuard('web')
            // ->profile(EditProfile::class)
            ->passwordReset()
            ->revealablePasswords()
            // ->emailVerification()
            // ->databaseNotifications()
            // ->databaseNotificationsPolling('360s')
            // ->databaseTransactions()
            ->readOnlyRelationManagersOnResourceViewPagesByDefault()
            ->globalSearchFieldKeyBindingSuffix()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->colors(fn() => FilamentPlugin::useColors())
            ->font('Play', provider: GoogleFontProvider::class)
            // ->font('Kufam', provider: BunnyFontProvider::class)
            ->favicon('/assets/logo.png')
            // ->brandLogo('/assets/logo.png')
            ->brandLogoHeight('2rem')
            ->sidebarWidth('18rem')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->assets([
                Css::make('app-css', Vite::asset('resources/css/app.css')),
                Js::make('app-js', Vite::asset('resources/js/app.js')),
            ]);
    }

    public static function useColors(): array
    {
        return [
            ...Color::all(),
            'primary' => Color::Indigo,
            'secondary' => Color::Sky,

            'info' => Color::Blue,
            'success' => Color::Emerald,
            'warning' => Color::Orange,
            'danger' => Color::Rose,
            'gray' => [
                50 => '250, 250, 251',
                100 => '238, 238, 245',
                200 => '224, 223, 238',
                300 => '198, 197, 218',
                400 => '159, 157, 192',
                500 => '123, 119, 165',
                600 => '92, 87, 131',
                700 => '65, 61, 97',
                800 => '45, 42, 69',
                900 => '30, 28, 49',
                950 => '22, 20, 35',
            ],
        ];
    }
}
