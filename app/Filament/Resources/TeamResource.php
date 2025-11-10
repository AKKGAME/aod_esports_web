<?php
// app/Filament/Resources/TeamResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Players & Teams';

    public static function form(Form $form): Form
    {
        // (၂) Team အသစ်ထည့်/ပြင်တဲ့အခါ သုံးမယ့် Form
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('logo_url')
                    ->label('Team Logo URL')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                // === (အမှားပြင်ဆင်ပြီး) Forms.Components အစား Forms\Components ===
                Forms\Components\Textarea::make('description')
                    ->label('Team Description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        // (၃) Team တွေ အားလုံးကို ပြမယ့် Table
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(asset('img/aod_logo.png')),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('players_count')
                    ->counts('players')
                    ->label('Total Players')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }    
}