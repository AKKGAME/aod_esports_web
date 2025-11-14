<?php

namespace App\Filament\Resources\ScrimResource\Pages;

use App\Filament\Resources\ScrimResource;
use App\Filament\Resources\ScrimResource\Widgets\ScrimKPIWidget;
use Filament\Resources\Pages\EditRecord;

class EditScrim extends EditRecord
{
    protected static string $resource = ScrimResource::class;

    // Header Widgets: Class Reference နဲ့သာ
    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         ScrimKPIWidget::class, // ✅ This is important
    //     ];
    // }
}
