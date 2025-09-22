<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;
    // redirect ke index
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Order Berhasil Diperbarui')
            ->body('Order telah berhasil disimpan.');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Order')
                ->modalDescription('Apakah Anda yakin ingin menghapus order #' . $this->record->id . '?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Order Berhasil Dihapus')
                        ->body("Order #{$record->id} telah berhasil dihapus.");
                }),
            Actions\ForceDeleteAction::make()
                ->modalHeading('Hapus Permanen Order')
                ->modalDescription('Apakah Anda yakin ingin menghapus permanen order ini? Data yang terhapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus Permanen')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Order Berhasil Dihapus Permanen')
                        ->body("Order #{$record->id} telah berhasil dihapus permanen.");
                }),
            Actions\RestoreAction::make(),
        ];
    }
}