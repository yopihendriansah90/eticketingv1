<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Tiket')
                ->modalDescription('Apakah Anda yakin ingin menghapus tiket ' . $this->record->name . '?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->successNotification(function ($record) {
                    return Notification::make()
                        ->success()
                        ->title('Tiket Berhasil Dihapus')
                        ->body("Tiket '{$record->name}' telah berhasil dihapus.");
                }),
        ];
    }
}