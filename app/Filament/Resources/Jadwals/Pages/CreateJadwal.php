<?php

namespace App\Filament\Resources\Jadwals\Pages;

use App\Filament\Resources\Jadwals\JadwalResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateJadwal extends CreateRecord
{
    protected static string $resource = JadwalResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Jadwal registered')
            ->body('New jadwal has been created successfully.');
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

