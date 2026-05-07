<?php

namespace App\Filament\Resources\Pondoks\Pages;

use App\Filament\Resources\Pondoks\PondokResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPondoks extends ListRecords
{
    protected static string $resource = PondokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
