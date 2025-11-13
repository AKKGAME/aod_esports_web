<?php
// app/Filament/Resources/UserResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Settings'; // Setting Group အသစ်

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                
                // (၁) Password ကို Hashing လုပ်ပြီးမှ Database ထဲ သိမ်းရန်
                Forms\Components\TextInput::make('password')
                    ->password()
                    // Create လုပ်ချိန်မှာ မဖြစ်မနေ လိုအပ်စေရန်
                    ->required(fn (string $operation): bool => $operation === 'create')
                    // Password ရိုက်လာမှသာ Hashing လုပ်ပြီး Database ထဲ သိမ်းရန်
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    // Edit လုပ်ချိန်မှာ Password ကို လုံခြုံရေးအရ မပြတော့ဘဲ၊ Field ကို ဗလာ ထားရင် password အဟောင်း မပြောင်းအောင် ထားရန်
                    ->dehydrated(fn (?string $state) => filled($state) ? $state : null)
                    ->maxLength(255),

                // (၂) Admin Permission Toggle
                Forms\Components\Toggle::make('is_admin')
                    ->label('Super Admin Access')
                    ->helperText('This user can see all data (Expenses/Income) and access critical settings.')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_admin')
                    ->label('Admin Only')
                    ->default(false),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}