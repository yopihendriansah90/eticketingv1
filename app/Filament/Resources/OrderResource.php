<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // urutkan berdasarkan data baru dibuat
    protected static ?string $navigationLabel = 'Orders';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $slug = 'orders';

    // tampilkan data tabel dari yang terbaru ke yang lama dibuat

protected static ?string $recordTitleAttribute = 'id';

    protected static function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected static function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->maxLength(8)
                    
                    ->numeric(),
                // status opton ['pending', 'confirmed', 'rejected'])->default('pending')
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->native(false),
                    
                Forms\Components\TextInput::make('proof_of_payment')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('proof_of_payment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    // urutkan dari yang terbaru

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
                        ->modalHeading('Hapus Order')
                        ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin menghapus order #' . $record->id . '?')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Order Dihapus')
                                ->body(fn ($record) => "Order #{$record->id} telah berhasil dihapus.")
                        ),
                    Tables\Actions\ForceDeleteAction::make()
                        ->modalHeading('Hapus Permanen Order')
                        ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin menghapus permanen order #' . $record->id . '? Data tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus Permanen')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Order Dihapus Permanen')
                                ->body(fn ($record) => "Order #{$record->id} telah berhasil dihapus permanen.")
                        ),
                    Tables\Actions\RestoreAction::make()
                        ->modalHeading('Pulihkan Order')
                        ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin memulihkan order #' . $record->id . '?')
                        ->modalSubmitActionLabel('Ya, Pulihkan')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Order Dipulihkan')
                                ->body(fn ($record) => "Order #{$record->id} telah berhasil dipulihkan.")
                        ),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalHeading('Hapus Order Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus order yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Order Dihapus')
                                ->body('Order yang dipilih berhasil dihapus.')
                        ),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->modalHeading('Hapus Permanen Order Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus permanen order yang dipilih? Data tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus Permanen')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Order Dihapus Permanen')
                                ->body('Order yang dipilih berhasil dihapus permanen.')
                        ),
                    Tables\Actions\RestoreBulkAction::make()
                        ->modalHeading('Pulihkan Order Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin memulihkan order yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Pulihkan')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Order Dipulihkan')
                                ->body('Order yang dipilih berhasil dipulihkan.')
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
