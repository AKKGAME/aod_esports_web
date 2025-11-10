<?php
// app/Filament/Resources/SponsorResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\SponsorResource\Pages;
use App\Models\Sponsor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Site Management'; // Group အသစ်

    // app/Filament/Resources/SponsorResource.php
    
    public static function form(Form $form): Form
    {
        // Sponsor အသစ်ထည့်/ပြင်တဲ့ Form
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Select::make('level')
                    ->options([
                        'Title Partner' => 'Title Partner',
                        'Official Partner' => 'Official Partner',
                        'Partner' => 'Partner',
                        'Supporter' => 'Supporter',
                    ])
                    ->default('Partner')
                    ->required(),

                Forms\Components\TextInput::make('logo_url')
                    ->label('Logo URL')
                    ->url()
                    ->required()
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('website_url')
                    ->label('Website Link (Optional)')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Sponsor Description (Optional)')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Show this sponsor on website?')
                    ->default(true)
                    ->required(),
                
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Sort order (0 is first).'),
            ]);
    }

    public static function table(Table $table): Table
    {
        // Sponsor တွေ အားလုံးကို ပြမယ့် Table
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->width(120) // ပုံကို နည်းနည်း ကြီးထားမယ်
                    ->height('auto'),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('level')
                    ->badge() // Badge လေးနဲ့ ပြမယ်
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sort')
                    ->sortable(),
            ])
            // === (အရေးကြီး) Drag & Drop နဲ့ Sort လုပ်နိုင်အောင် ===
            ->reorderable('sort_order') 
            ->defaultSort('sort_order', 'asc') // Sort Order အတိုင်း စဉ်ထားမယ်
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSponsors::route('/'),
            'create' => Pages\CreateSponsor::route('/create'),
            'edit' => Pages\EditSponsor::route('/{record}/edit'),
        ];
    }    
}