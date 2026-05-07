<?php

namespace App\Filament\Resources\Pondoks\Pages;

use App\Filament\Resources\Pondoks\PondokResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePondok extends CreateRecord
{
    protected static string $resource = PondokResource::class;
    protected static bool $canCreateAnother = false;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pondok registered')
            ->body('New pondok has been created successfully.');
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction()->label('Back'),
        ];
    }
}
