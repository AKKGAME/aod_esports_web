<?php
// app/Filament/Pages/Dashboard.php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\EventCalendarWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -2; 
    protected static string $view = 'filament.pages.dashboard';

    // === (၂) Widget ကို ဒီ Page မှာ ပြပါလို့ Register လုပ်ပါ ===
    public function getWidgets(): array
    {
        return [
            EventCalendarWidget::class,
        ];
    }

    // === (၃) Widget ကို Columns ဘယ်လောက် သုံးမလဲ သတ်မှတ်ပါ ===
    public function getColumns(): int | string | array
    {
        return 1; // Card ၃ ခုကို တစ်တန်းတည်း ပြမယ်
    }
}