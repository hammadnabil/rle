<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\UserResource\Pages;
    use App\Models\User;
    use Filament\Forms;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\PasswordInput;
    use Filament\Forms\Components\TextArea;
    use Illuminate\Support\Facades\Hash;

    class UserResource extends Resource
    {
        protected static ?string $model = User::class;

        protected static ?string $navigationIcon = 'heroicon-o-user';

        public static function form(Forms\Form $form): Forms\Form
        {
            return $form->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                    
                    Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->visible(fn (string $context): bool => $context === 'create'),
                        
                    
                Forms\Components\select::make('jabatan')
                ->options([
                    'pegawai' => 'pegawai',
                    'atasan' => 'atasan',
                    
                ])->required()
                ->default('pegawai') 
                
            ]);
        }

        public static function table(Tables\Table $table): Tables\Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                    Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                    Tables\Columns\TextColumn::make('jabatan')->sortable()
                ])
                ->filters([
                    // Filter can be added here
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
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
