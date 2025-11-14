<?php
// app/Filament/Resources/ScrimResource/RelationManagers/DetailsRelationManager.php
namespace App\Filament\Resources\ScrimResource\RelationManagers;

use App\Models\Player;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details'; // ScrimDetail model ကို ညွှန်း

    public function form(Form $form): Form
    {
        // Add/Edit Player Result Modal Form
        return $form
            ->schema([
                Forms\Components\Select::make('player_id')
                    ->label('Player')
                    ->options(Player::pluck('ign', 'id')->toArray()) // Player list ကို ဆွဲထုတ်ပါ
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('Map')
                    ->label('Map')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Kill')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('Assists')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('Damage')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('Heals')
                    ->label('Heals') // Top Healer အတွက်
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('Survival_Time')
                    ->label('Survival Time (Seconds)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('Desc')
                    ->label('Notes')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        // Player Result Table
        return $table
            ->recordTitleAttribute('player.ign')
            ->columns([
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
                    ->label('Heals') // Top Healer အတွက်
                    ->sortable(),
                Tables\Columns\TextColumn::make('Survival_Time')
                    ->label('Survival (Sec)'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add Result'),
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
}