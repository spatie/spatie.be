<?php

namespace App\Filament\Resources\Customers;

use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Filament\Tables\Columns\CopyableColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LicenseResource extends Resource
{
    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $model = License::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextColumn::make('id')->sortable(),
                ResourceLinkColumn::make(
                    'assignment.purchasable.title',
                    function (License $record) {
                        if(!$record->assignment) {
                            return null;
                        }

                        return route('filament.admin.resources.customers.purchase-assignments.edit', $record->assignment);
                })
                ->state(function (License $record) {
                    if ($record->assignment?->purchasable) {
                        return $record->assignment->purchasable->title ." ({$record->assignment->purchasable->product->title})";
                    }

                    if ($record->assignment?->bundle) {
                        return $record->assignment->bundle->title . " ({$record->assignment->bundle->formattedProductNames()})";
                    }

                    return '-';
                })->sortable()->searchable(),
                ResourceLinkColumn::make(
                    'assignment.user.email',
                    function (License $record) {
                        if(!$record->assignment) {
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
            ->actions([
                Action::make('regenerate')
                    ->button()
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(
                        fn (License $record) =>
                        $record->update(['key' => Str::random(64)])
                    ),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => \App\Filament\Resources\Customers\LicenseResource\Pages\ListLicenses::route('/'),
            'create' => \App\Filament\Resources\Customers\LicenseResource\Pages\CreateLicense::route('/create'),
            'edit' => \App\Filament\Resources\Customers\LicenseResource\Pages\EditLicense::route('/{record}/edit'),
        ];
    }
}
