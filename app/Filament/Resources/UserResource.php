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
    use Filament\Forms\Components\DatePicker;
    use Filament\Forms\Components\Select;

    class UserResource extends Resource
    {
        protected static ?string $model = User::class;

        protected static ?string $navigationIcon = 'heroicon-o-user';

        public static function form(Forms\Form $form): Forms\Form
{
    return $form->schema([
        TextInput::make('name')
            ->required()
            ->maxLength(255),

        TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255),

        TextInput::make('password')
            ->password()
            ->label('Password')
            ->required(fn (string $context): bool => $context === 'create')
            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
            ->dehydrated(fn (?string $state): bool => filled($state))
            ->visible(fn (string $context): bool => $context === 'create'),

        Select::make('jabatan')
            ->options([
                'pegawai' => 'pegawai',
                'atasan' => 'atasan',
                'Tata Usaha' => 'Tata Usaha',
                'Kepala Sekolah' => 'Kepala Sekolah',
            ])
            ->required()
            ->default('pegawai'),

        TextInput::make('no_wa')
            ->label('No. WhatsApp')
            ->tel()
            ->maxLength(20),

        TextInput::make('umur')
            ->numeric()
            ->minValue(1)
            ->maxValue(100),

        DatePicker::make('tanggal_bergabung')
            ->label('Tanggal Bergabung'),

        Select::make('gender')
            ->options([
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
            ])
            ->required(),

             TextInput::make('fonnte_token')
            ->maxLength(255),


            
    ]);
}

        public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('jabatan')->sortable(),
            Tables\Columns\TextColumn::make('no_wa')->label('No. WA'),
            Tables\Columns\TextColumn::make('umur'),
            Tables\Columns\TextColumn::make('tanggal_bergabung')->date('d M Y')->label('Tanggal Bergabung'),
            Tables\Columns\TextColumn::make('gender')->label('Jenis Kelamin')
                ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
        ])
        ->filters([
            // Filter bisa ditambahkan jika perlu
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
