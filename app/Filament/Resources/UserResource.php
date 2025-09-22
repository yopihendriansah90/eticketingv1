<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    // ->required()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255),
                Select::make('roles')
                    // ->multiple()
                    ->preload()
                    ->relationship('roles', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->modalHeading('Hapus Pengguna')
                        ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin menghapus pengguna ' . $record->name . '?')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Pengguna Dihapus')
                                ->body(fn ($record) => "Pengguna '{$record->name}' telah berhasil dihapus.")
                        ),
                    Tables\Actions\ForceDeleteAction::make()
                        ->modalHeading('Hapus Permanen Pengguna')
                        ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin menghapus permanen pengguna ' . $record->name . '? Data tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus Permanen')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Pengguna Dihapus Permanen')
                                ->body(fn ($record) => "Pengguna '{$record->name}' telah berhasil dihapus permanen.")
                        ),
                    Tables\Actions\RestoreAction::make()
                        ->modalHeading('Pulihkan Pengguna')
                        ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin memulihkan pengguna ' . $record->name . '?')
                        ->modalSubmitActionLabel('Ya, Pulihkan')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Pengguna Dipulihkan')
                                ->body(fn ($record) => "Pengguna '{$record->name}' telah berhasil dipulihkan.")
                        ),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalHeading('Hapus Pengguna Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Pengguna Dihapus')
                                ->body('Pengguna yang dipilih berhasil dihapus.')
                        ),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->modalHeading('Hapus Permanen Pengguna Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus permanen pengguna yang dipilih? Data tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus Permanen')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Pengguna Dihapus Permanen')
                                ->body('Pengguna yang dipilih berhasil dihapus permanen.')
                        ),
                    Tables\Actions\RestoreBulkAction::make()
                        ->modalHeading('Pulihkan Pengguna Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin memulihkan pengguna yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Pulihkan')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Pengguna Dipulihkan')
                                ->body('Pengguna yang dipilih berhasil dipulihkan.')
                        ),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
