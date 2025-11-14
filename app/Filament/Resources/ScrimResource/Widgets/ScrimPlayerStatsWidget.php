<?php
// app/Filament/Resources/ScrimResource/Widgets/ScrimPlayerStatsWidget.php
namespace App\Filament\Resources\ScrimResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\ScrimDetail;
use App\Models\Player;
use Illuminate\Database\Eloquent\Builder;

class ScrimPlayerStatsWidget extends BaseWidget
{
    // (၁) Scrim ID (Record) ကို ဒီမှာ ကြေညာပါ
    public $record;

    // (၂) Table ရဲ့ ခေါင်းစဉ်
    protected static ?string $heading = 'Player Stats (Full Results)';

    // (၃) Table Data တွေကို Scrim ID နဲ့ Filter လုပ်ပါ
    protected function getTableQuery(): Builder
    {
        return ScrimDetail::query()
            ->where('scrim_id', $this->record)
            ->join('players', 'scrim_details.player_id', '=', 'players.id') // Player name တွေ ယူဖို့
            ->select('scrim_details.*', 'players.ign');
    }

    // (၄) DetailsRelationManager ထဲက Table Columns တွေကို ကူးထည့်ပါ
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('player.ign')
                ->label('Player IGN')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('Map')
                ->label('Map'),
            Tables\Columns\TextColumn::make('Kill')
                ->sortable(),
            Tables\Columns\TextColumn::make('Damage')
                ->sortable(),
            Tables\Columns\TextColumn::make('Heals')
                ->label('Heals')
                ->sortable(),
            Tables\Columns\TextColumn::make('Survival_Time')
                ->label('Survival (Sec)'),
        ];
    }
}