<?php
// app/Providers/Filament/AdminPanelProvider.php
namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// === (၁) Resource/Page တွေ အားလုံးကို use လုပ်ပါ ===
use App\Filament\Pages\Dashboard;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\ExpenseResource;
use App\Filament\Resources\IncomeResource;
use App\Filament\Resources\PlayerResource;
use App\Filament\Resources\TeamResource; // (TeamResource လို့ ပြင်ထား)
use App\Filament\Resources\SponsorResource;

// === (၂) Calendar Plugin ကို use လုပ်ပါ ===
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            
            // (Page အသစ်ကို Register လုပ်ပါ)
            ->pages([
                Dashboard::class,
            ])
            
            // (Resource (Menu) အားလုံးကို Register လုပ်ပါ)
            ->resources([
                EventResource::class,
                ExpenseResource::class,
                IncomeResource::class,
                PlayerResource::class,
                TeamResource::class,
                SponsorResource::class,
            ])
            
            // (Widget တွေကို Auto-discover လုပ်ပါ)
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])

            // === (၃) Calendar Plugin ကို ဒီမှာ Register လုပ်ပါ ===
            ->plugin(
                FilamentFullCalendarPlugin::make()
            )

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}