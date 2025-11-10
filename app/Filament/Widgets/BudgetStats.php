<?php
// app/Filament/Widgets/BudgetStats.php
namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Forms\Components\Select; // Filter အတွက်

class BudgetStats extends BaseWidget
{
    // === (၁) Filter ကို ဒီမှာ သတ်မှတ်ပါ ===
    public ?string $filter = 'this_month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'this_week' => 'This Week',
            'this_month' => 'This Month',
            'last_month' => 'Last Month',
            'this_year' => 'This Year',
        ];
    }
    
    // === (၂) တွက်ချက်မယ့် Logic ===
    protected function getStats(): array
    {
        // Filter က ရွေးထားတဲ့ တန်ဖိုး (today, this_month, etc.)
        $filterValue = $this->filter;

        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($filterValue === 'this_week') {
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
        } elseif ($filterValue === 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($filterValue === 'last_month') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        } elseif ($filterValue === 'this_year') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
        }

        // === Role-based Query ===
        $queryUserId = null;
        if (auth()->user() && !auth()->user()->is_admin) {
            $queryUserId = auth()->id(); // Admin မဟုတ်ရင် ကိုယ့် ID ပဲ ယူမယ်
        }
        
        // Income တွက်ချက်ခြင်း
        $totalIncome = Income::query()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($queryUserId, fn ($query) => $query->where('user_id', $queryUserId))
            ->sum('amount');

        // Expense တွက်ချက်ခြင်း
        $totalExpense = Expense::query()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->when($queryUserId, fn ($query) => $query->where('user_id', $queryUserId))
            ->sum('amount');
            
        $balance = $totalIncome - $totalExpense;

        // === (၃) Card ၃ ခု ပြန်ပို့ခြင်း ===
        return [
            Stat::make('Take Money (Income)', number_format($totalIncome) . ' Ks')
                ->description('Income for selected range')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray'),
            Stat::make('Total Expenses', number_format($totalExpense) . ' Ks')
                ->description('Expenses for selected range')
                ->color('danger')
                ->icon('heroicon-o-shopping-cart'),
            Stat::make('Balance', number_format($balance) . ' Ks')
                ->description('Income - Expenses')
                ->color($balance >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-scale'),
        ];
    }
}