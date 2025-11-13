<?php
// app/Filament/Resources/EventResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// === (၁) Filter တွေ သုံးဖို့ ဒီ (၂) ခုကို use လုပ်ပါ ===
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Site Management'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                
                // === (၂) Form Layout ကို Grid နဲ့ ပြင်ဆင်ပါ ===
                Forms\Components\Grid::make(2) // 2-column grid
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->nullable()
                            ->after('start_date'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // === (၃) Default Sort ကို 'start_date' (desc) အဖြစ် သတ်မှတ်ပါ ===
            ->defaultSort('start_date', 'desc') // (နောက်ဆုံးပွဲက အပေါ်ဆုံး)
            
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
            ])
            
            // === (၄) Filter (စစ်ထုတ်) တွေကို ထည့်ပါ ===
            ->filters([
                Filter::make('upcoming')
                    ->label('Upcoming Events')
                    ->query(fn (Builder $query): Builder => $query->where('start_date', '>', now()))
                    ->default(), // (Default အနေနဲ့ ဒီ Filter ကို ဖွင့်ထားမယ်)

                Filter::make('past')
                    ->label('Past Events')
                    ->query(fn (Builder $query): Builder => $query->where('end_date', '<', now())),
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }    
}