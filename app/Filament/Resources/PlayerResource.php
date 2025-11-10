<?php
// app/Filament/Resources/PlayerResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PlayerResource\Pages;
use App\Models\Player;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlayerResource extends Resource
{
    protected static ?string $navigationGroup = 'Players & Teams';

    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        // Player "Add" / "Edit" Form
        return $form
            ->schema([
                Forms\Components\Section::make('Player Info')
                    ->description('Player ၏ အခြေခံ အချက်အလက်များ')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('ign')
                            ->label('IGN (In-Game Name)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('real_name')
                            ->label('Real Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('role')
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Player' => 'Player',
                                'Substitute' => 'Substitute',
                                'Inactive' => 'Inactive',
                                'Coach' => 'Coach',
                                'TM' => 'TM',
                                'GM' => 'GM',
                            ])
                            ->default('Player')
                            ->required(),
                        Forms\Components\TextInput::make('photo_url')
                            ->label('Photo URL')
                            ->url()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),
                
                Forms\Components\Section::make('Team Info')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('team_id')
                            ->label('Team')
                            ->relationship('team', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('No Team (Free Agent)')
                            
                            // === (createOptionForm) ===
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Team Name အသစ်')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                            // ==========================================

                        Forms\Components\TextInput::make('country_code')
                            ->label('Country Code (e.g., MM)')
                            ->maxLength(5),
                        Forms\Components\DatePicker::make('join_date'),
                        Forms\Components\TextInput::make('salary')
                            ->numeric()
                            ->prefix('Ks')
                            ->default(0),
                        Forms\Components\Textarea::make('bio')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Social Media')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')->url()->prefixIcon('heroicon-o-globe-alt'),
                        Forms\Components\TextInput::make('youtube_url')->url()->prefixIcon('heroicon-o-globe-alt'),
                        Forms\Components\TextInput::make('tiktok_url')->url()->prefixIcon('heroicon-o-globe-alt'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        // Player Table
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Photo')
                    ->height(40)
                    ->square()
                    ->defaultImageUrl(asset('assets/img/default-player.png')),
                Tables\Columns\TextColumn::make('ign')
                    ->label('IGN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('real_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('salary')
                    ->numeric()
                    ->money('MMK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Player' => 'success',
                        'Substitute' => 'warning',
                        'Inactive' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('join_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // (Filter တွေ ထပ်ထည့်ရန်)
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
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }
}