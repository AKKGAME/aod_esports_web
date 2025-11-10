<?php
// app/Filament/Resources/IncomeResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Models\Income;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder; // Import Builder

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationGroup = 'Expenses'; // Sidebar မှာ Group ခွဲမယ်

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->default(auth()->id()) // Default ကိုယ့်နာမည်
                    ->visible(fn () => auth()->user()->is_admin) // Admin မှ User ရွေးခွင့်ပြုမယ်
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Ks'),
                Forms\Components\DateTimePicker::make('transaction_date')
                    ->required()
                    ->default(now()),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => auth()->user()->is_admin), // Admin မှ User  column ကို မြင်ရမယ်
                Tables\Columns\TextColumn::make('amount')
                    ->money('MMK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
    
    // === (အရေးကြီး) Role-based Security ===
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user()->is_admin) {
            return $query; // Admin က အကုန်မြင်ရမယ်
        }
        return $query->where('user_id', auth()->id()); // User က ကိုယ့် data ပဲ မြင်ရမယ်
    }
    
    // ... (getEloquentQuery function) ...

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
