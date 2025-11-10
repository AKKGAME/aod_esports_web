<?php
// app/Filament/Pages/Dashboard.php
namespace App\Filament\Pages;

use Filament\Pages\Page;

// === (၁) Widget ကို ဒီမှာ use လုပ်ပါ ===
use App\Filament\Widgets\BudgetStats; 

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -2; // ထိပ်ဆုံးမှာ ထားမယ်
    protected static string $view = 'filament.pages.dashboard';

    // === (၂) Widget ကို ဒီ Page မှာ ပြပါလို့ Register လုပ်ပါ ===
    public function getWidgets(): array
    {
        return [
            BudgetStats::class,
        ];
    }

    // === (၃) Widget ကို Columns ဘယ်လောက် သုံးမလဲ သတ်မှတ်ပါ ===
    public function getColumns(): int | string | array
    {
        return 3; // Card ၃ ခုကို တစ်တန်းတည်း ပြမယ်
    }
}