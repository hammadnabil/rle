<?php

namespace App\Filament\Resources\AtasanResource\Pages;

use App\Filament\Resources\AtasanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtasans extends ListRecords
{
    protected static string $resource = AtasanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
