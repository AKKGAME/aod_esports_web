<?php
// app/Filament/Resources/ExpenseResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
// use App\Filament\Resources\ExpenseResource\Widgets\ExpenseStats; // <-- ဒီမှာ မလိုတော့ပါဘူး
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Expenses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->default(auth()->id())
                    ->visible(fn () => auth()->user()->is_admin)
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('decs')
                    ->label('Description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Ks'),
                Forms\Components\DateTimePicker::make('transaction_date')
                    ->required()
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->visible(fn () => auth()->user()->is_admin),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('MMK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('decs')
                    ->label('Description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // === Filter တွေ ဒီမှာ ရှိနေရပါမယ် ===
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by User')
                    ->visible(fn () => auth()->user()->is_admin),

                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('start_date')
                            ->default(date('Y-01-01')),
                        Forms\Components\DatePicker::make('end_date')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['start_date'], fn ($q, $date) => $q->whereDate('transaction_date', '>=', $date))
                            ->when($data['end_date'], fn ($q, $date) => $q->whereDate('transaction_date', '<=', $date));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    // === Role-based Security ===
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user() && auth()->user()->is_admin) {
            return $query; // Admin က အကုန်မြင်ရမယ်
        }
        return $query->where('user_id', auth()->id()); // User က ကိုယ့် data ပဲ မြင်ရမယ်
    }
    
    // === Widget ကို ဒီမှာ Register မလုပ်တော့ပါဘူး ===
    // public static function getWidgets(): array
    // {
    //     return [];
    // }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
    
}