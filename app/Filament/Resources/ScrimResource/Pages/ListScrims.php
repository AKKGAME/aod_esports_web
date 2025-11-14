<?php

namespace App\Filament\Resources\ScrimResource\Pages;

use App\Filament\Resources\ScrimResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScrims extends ListRecords
{
    protected static string $resource = ScrimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
