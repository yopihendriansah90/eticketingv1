<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('poster')
                    ->collection('posters')
                    ->columnSpanFull()
                    ->label('Poster Event'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                // toolbar
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'undo',
                    ])

                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                ->native(false)
                    ->required(),
            ]); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // image spatie
                SpatieMediaLibraryImageColumn::make('poster')
                    ->collection('posters')
                    ->conversion('thumb')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    // ubah format tanggal dan jam nya dengan formta indonesia besaert zona wib
                    ->date('d F Y H:i')

                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->date('d F Y H:i')

                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // group action 
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->modalHeading('Hapus Event')
                        ->modalDescription(fn($record) => 'Apakah Anda yakin ingin menghapus event ' . $record->title . '?')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Event Dihapus')
                                ->body('Event telah berhasil dihapus.')
                        ),
                    Tables\Actions\ForceDeleteAction::make()
                        ->modalHeading('Hapus Permanen Event')
                        ->modalDescription(fn($record) => 'Apakah Anda yakin ingin menghapus permanen event ' . $record->title . '? Data tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus Permanen')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Event Dihapus Permanen')
                                ->body('Event telah berhasil dihapus permanen.')
                        ),
                    Tables\Actions\RestoreAction::make()
                        ->modalHeading('Pulihkan Event')
                        ->modalDescription(fn($record) => 'Apakah Anda yakin ingin memulihkan event ' . $record->title . '?')
                        ->modalSubmitActionLabel('Ya, Pulihkan')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Event Dipulihkan')
                                ->body(fn($record) => "Event '{$record->title}' telah berhasil dipulihkan.")
                        ),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
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
