<?php
// app/Filament/Resources/ExpenseResource/Pages/ListExpenses.php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

// === (၁) Widget ကို ဒီမှာ use လုပ်ပါ ===
use App\Filament\Resources\ExpenseResource\Widgets\ExpenseStats;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
}