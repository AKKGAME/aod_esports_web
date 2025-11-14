<?php
// app/Filament/Resources/ScrimResource/Pages/ViewScrimAnalysis.php
namespace App\Filament\Resources\ScrimResource\Pages;

use App\Filament\Resources\ScrimResource;
use Filament\Resources\Pages\Page;
use App\Models\Scrim;

// === (၁) Widget (၂) ခုလုံးကို use လုပ်ပါ ===
use App\Filament\Resources\ScrimResource\Widgets\ScrimKPIWidget;
use App\Filament\Resources\ScrimResource\Widgets\ScrimPlayerStatsWidget; // <-- Widget အသစ်

class ViewScrimAnalysis extends Page
{
    protected static string $resource = ScrimResource::class;
    
    public Scrim $record;

    protected static ?string $title = 'Scrim Analysis';
    protected static string $view = 'filament.resources.scrim-resource.pages.view-scrim-analysis';

    // (KPI Cards)
    protected function getHeaderWidgets(): array
    {
        return [
            ScrimKPIWidget::class, 
        ];
    }

    // === (၂) Player Stats Table Widget (အသစ်) ကို ဒီမှာ ပြပါ ===
    protected function getFooterWidgets(): array
    {
        return [
            ScrimPlayerStatsWidget::class, // <-- RelationManager အစား Widget အသစ်
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return 1; 
    }

    // (Edit Page ကို ပြန်သွားဖို့ Action)
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('edit')
                ->label('Edit Scrim Details')
                ->icon('heroicon-o-pencil-square')
                ->color('gray')
                ->url(ScrimResource::getUrl('edit', ['record' => $this->record])),
        ];
    }
}