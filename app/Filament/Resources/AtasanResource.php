<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtasanResource\Pages;
use App\Filament\Resources\AtasanResource\RelationManagers;
use App\Models\Atasan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtasanResource extends Resource
{
    protected static ?string $model = Atasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->required(),
            Forms\Components\TextInput::make('jabatan')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\TextInput::make('no_hp')->nullable(),
            Forms\Components\TextInput::make('password')
    ->password()
    ->label('Password')
    ->required(fn (string $context): bool => $context === 'create')
    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
    ->dehydrated(fn (?string $state): bool => filled($state))
    ->visible(fn (string $context): bool => $context === 'create')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('jabatan'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('no_hp'),
                
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAtasans::route('/'),
            'create' => Pages\CreateAtasan::route('/create'),
            'edit' => Pages\EditAtasan::route('/{record}/edit'),
        ];
    }
}
