<?php

namespace App\Filament\Resources;

use App\Models\Scrim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ScrimResource\RelationManagers\DetailsRelationManager;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\ScrimResource\Pages;
use App\Filament\Resources\ScrimResource\Pages\ViewScrimAnalysis;

class ScrimResource extends Resource
{
    protected static ?string $model = Scrim::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Scrims & Finance';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('scrim_name')->required()->maxLength(255)->columnSpanFull(),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('fee')->required()->numeric()->prefix('Ks'),
                Forms\Components\TextInput::make('prize_pool')->numeric()->prefix('Ks')->default(0),
                Forms\Components\TextInput::make('rank')->placeholder('e.g. #1, #2'),
            ]),
            Forms\Components\DateTimePicker::make('match_time')->required()->default(now()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('match_time', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('scrim_name')->searchable(),
                Tables\Columns\TextColumn::make('fee')->money('MMK')->sortable()->summarize(Sum::make()->label('Total Fee')->money('MMK')),
                Tables\Columns\TextColumn::make('prize_pool')->label('Prize')->money('MMK')->sortable()->summarize(Sum::make()->label('Total Prize')->money('MMK')),
                Tables\Columns\TextColumn::make('rank')->sortable(),
                Tables\Columns\TextColumn::make('match_time')->label('Date')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_range')->form([
                    Forms\Components\DatePicker::make('start_date')->default(date('Y-m-01')),
                    Forms\Components\DatePicker::make('end_date')->default(now()),
                ])->query(fn (Builder $query, array $data) => 
                    $query->when($data['start_date'], fn ($q, $d) => $q->whereDate('match_time', '>=', $d))
                          ->when($data['end_date'], fn ($q, $d) => $q->whereDate('match_time', '<=', $d))
                ),
            ])
            ->actions([
                Tables\Actions\Action::make('viewAnalysis')
                    ->label('View Analysis')
                    ->icon('heroicon-o-chart-pie')
                    ->color('gray')
                    ->url(fn (Scrim $record): string => Pages\ViewScrimAnalysis::getUrl(['record' => $record])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [DetailsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScrims::route('/'),
            'create' => Pages\CreateScrim::route('/create'),
            'edit' => Pages\EditScrim::route('/{record}/edit'),
            'analysis' => Pages\ViewScrimAnalysis::route('/{record}/analysis'),
        ];
    }
}
