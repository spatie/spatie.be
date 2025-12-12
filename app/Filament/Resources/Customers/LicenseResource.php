<?php

namespace App\Filament\Resources\Customers;

use App\Domain\Shop\Models\License;
use App\Filament\Resources\Customers\LicenseResource\Pages\CreateLicense;
use App\Filament\Resources\Customers\LicenseResource\Pages\EditLicense;
use App\Filament\Resources\Customers\LicenseResource\Pages\ListLicenses;
use App\Filament\Tables\Columns\CopyableColumn;
use App\Filament\Tables\Columns\LicensePurchasableNameColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LicenseResource extends Resource
{
    protected static string | \UnitEnum | null $navigationGroup = 'Customers';

    protected static ?string $model = License::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('id')
                            ->disabled(),
                        TextInput::make('key')
                            ->columnStart(1),
                        TextInput::make('domain')
                            ->columnStart(1),
                        TextInput::make('satis_authentication_count')
                            ->columnStart(1)
                            ->disabled(),
                        DateTimePicker::make('expires_at')
                            ->columnStart(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                LicensePurchasableNameColumn::make(),
                TextColumn::make('assignment.purchase.receipt.order_id')
                    ->label('Paddle ID')
                    ->searchable(),
                ResourceLinkColumn::make(
                    'assignment.purchase.id',
                    function (License $record) {
                        if (! $record->assignment) {
                            return null;
                        }

                        return route('filament.admin.resources.customers.purchases.edit', $record->assignment->purchase);
                    }
                )
                    ->label('Purchase ID')
                    ->searchable(),
                ResourceLinkColumn::make(
                    'assignment.user.email',
                    function (License $record) {
                        if (! $record->assignment) {
                            return null;
                        }

                        return route('filament.admin.resources.customers.purchase-assignments.edit', $record->assignment);
                    }
                )->searchable(),
                CopyableColumn::make('key')
                    ->limit(10)
                    ->searchable(),
                TextColumn::make('satis_authentication_count')->sortable(),
                TextColumn::make('expires_at')->date()->sortable(),
            ])
            ->recordActions([
                Action::make('regenerate')
                    ->button()
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(
                        fn (License $record) =>
                        $record->update(['key' => Str::random(64)])
                    ),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListLicenses::route('/'),
            'create' => CreateLicense::route('/create'),
            'edit' => EditLicense::route('/{record}/edit'),
        ];
    }
}
