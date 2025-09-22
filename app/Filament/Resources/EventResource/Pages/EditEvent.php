<?php

namespace App\Filament\Resources\EventResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EventResource;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    // notifikasi
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Event Berhasil Diperbarui')
            ->body('Event telah berhasil disimpan.');
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Event')
                // nama event dalam description
                ->modalDescription('Apakah Anda yakin ingin menghapus event ' . $this->record->title . '?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Event Berhasil Dihapus')
                        ->body("Event '{$record->title}' telah berhasil dihapus.");
                }),
            Actions\ForceDeleteAction::make()
                ->modalHeading('Hapus Permanen Event')
                ->modalDescription('Apakah Anda yakin ingin menghapus permanen event ini? Data yang terhapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus Permanen')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Event Berhasil Dihapus Permanen')
                        ->body("Event '{$record->title}' telah berhasil dihapus permanen.");
                }),
            Actions\RestoreAction::make(),
        ];
    }
}
