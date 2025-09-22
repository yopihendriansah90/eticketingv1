<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    // redirect ke halaman index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    // notifikasi berhasil edit data
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pengguna Diperbarui')
            ->body('Pengguna telah berhasil disimpan.');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Pengguna')
                ->modalDescription('Apakah Anda yakin ingin menghapus pengguna ' . $this->record->name . '?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Pengguna Berhasil Dihapus')
                        ->body("Pengguna '{$record->name}' telah berhasil dihapus.");
                }),
            Actions\ForceDeleteAction::make()
                ->modalHeading('Hapus Permanen Pengguna')
                ->modalDescription('Apakah Anda yakin ingin menghapus permanen pengguna ini? Data yang terhapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus Permanen')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Pengguna Berhasil Dihapus Permanen')
                        ->body("Pengguna '{$record->name}' telah berhasil dihapus permanen.");
                }),
            Actions\RestoreAction::make(),
        ];
    }
}