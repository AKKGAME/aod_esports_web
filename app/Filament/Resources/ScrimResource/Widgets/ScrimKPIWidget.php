<?php

namespace App\Filament\Resources\ScrimResource\Widgets;

use App\Models\ScrimDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ScrimKPIWidget extends BaseWidget
{
    // Scrim Edit Page က Scrim ID ကို Livewire automatically inject လုပ်မယ်
    public $record;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $allDetails = ScrimDetail::with('player')
            ->where('scrim_id', $this->record)
            ->get();

        if ($allDetails->isEmpty()) {
            return [
                Stat::make('No Data', 'Add player results below')
                    ->descriptionIcon('heroicon-o-information-circle')
                    ->color('warning'),
            ];
        }

        $topFragger = $allDetails->sortByDesc('Kill')->first();
        $damageLeader = $allDetails->sortByDesc('Damage')->first();
        $longestSurvival = $allDetails->sortByDesc('Survival_Time')->first();
        $topHealer = $allDetails->sortByDesc('Heals')->first();

        return [
            Stat::make('TOTAL KILLS', number_format($allDetails->sum('Kill')))
                ->description(number_format($allDetails->sum('Damage')) . ' Total Damage')
                ->color('danger')
                ->descriptionIcon('heroicon-o-fire'),

            Stat::make('TOTAL HEALS', number_format($allDetails->sum('Heals')))
                ->description('Total health recovered')
                ->color('info')
                ->descriptionIcon('heroicon-o-heart'),

            Stat::make('TOP FRAGGER', number_format($topFragger->Kill) . ' Kills')
                ->description(optional($topFragger->player)->ign ?? 'Unknown')
                ->color('success')
                ->descriptionIcon('heroicon-o-user-circle'),

            Stat::make('DAMAGE LEADER', number_format($damageLeader->Damage) . ' Damage')
                ->description(optional($damageLeader->player)->ign ?? 'Unknown')
                ->color('rose')
                ->descriptionIcon('heroicon-o-bolt'),

            Stat::make('LONGEST SURVIVAL', $this->formatSurvivalTime($longestSurvival->Survival_Time))
                ->description(optional($longestSurvival->player)->ign ?? 'Unknown')
                ->color('warning')
                ->descriptionIcon('heroicon-o-clock'),

            Stat::make('TOP HEALER', number_format($topHealer->Heals) . ' Heals')
                ->description(optional($topHealer->player)->ign ?? 'Unknown')
                ->color('primary')
                ->descriptionIcon('heroicon-o-star'),
        ];
    }

    private function formatSurvivalTime(int|null $seconds): string
    {
        if (!$seconds) return '00:00';
        $m = floor($seconds / 60);
        $s = $seconds % 60;
        return sprintf('%02d:%02d', $m, $s);
    }
}
