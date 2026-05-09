<?php

namespace App\Filament\Resources\Pondoks\Pages;

use App\Filament\Resources\Pondoks\PondokResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPondok extends EditRecord
{
    protected static string $resource = PondokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction()->label('Back'),
        ];
    }
}
