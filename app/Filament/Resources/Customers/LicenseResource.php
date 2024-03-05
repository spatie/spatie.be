<?php

namespace App\Filament\Resources\Customers;

use App\Domain\Shop\Models\License;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ResourceLinkColumn::make(
                    'assignment.user.email',
                    fn (License $record) => route('filament.admin.resources.customers.purchase-assignments.edit', $record->assignment)
                )->searchable(),
                TextColumn::make('key')
                    ->copyable()
                    ->icon('heroicon-o-document-duplicate')
                    ->iconPosition(IconPosition::After)
                    ->searchable(),
                TextColumn::make('satis_authentication_count')->sortable(),
                TextColumn::make('expires_at')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
