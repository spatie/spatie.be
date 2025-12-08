<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\UserResource\Actions\TransferPurchaseAssignmentAction;
use App\Filament\Resources\Customers\UserResource\Actions\TransferPurchaseToUserAction;
use App\Filament\Resources\Customers\UserResource\Pages\CreateUser;
use App\Filament\Resources\Customers\UserResource\Pages\EditUser;
use App\Filament\Resources\Customers\UserResource\Pages\ListUsers;
use App\Filament\Resources\Customers\UserResource\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\Customers\UserResource\RelationManagers\LicensesRelationManager;
use App\Filament\Resources\Customers\UserResource\RelationManagers\PurchasesRelationManager;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\CopyableColumn;
use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use STS\FilamentImpersonate\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Customers';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('uuid')
                            ->label('UUID')
                            ->maxLength(36)
                            ->disabled(),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnStart(1),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnStart(1),
                        TextInput::make('github_id')
                            ->columnStart(1)
                            ->numeric(),
                        TextInput::make('github_username')
                            ->maxLength(255),
                        Toggle::make('is_sponsor')
                            ->disabled()
                            ->columnStart(1),
                        Toggle::make('is_admin')
                            ->columnStart(1)
                            ->required(),
                        Toggle::make('has_access_to_unreleased_products')
                            ->columnStart(1)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->default(fn (User $record) => gravatar_url($record->email)),

                TextColumn::make('name')
                    ->searchable(),

                CopyableColumn::make('email')
                    ->searchable(),

                TextColumn::make('github_username')
                    ->searchable(),

                BooleanColumn::make('is_sponsor')->default(false),
                BooleanColumn::make('is_admin'),
                BooleanColumn::make('has_access_to_unreleased_products'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->recordActions([
                Impersonate::make(),
                EditAction::make(),
                ActionGroup::make([
                    TransferPurchaseAssignmentAction::make(),
                    TransferPurchaseToUserAction::make(),
                ]),
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
            PurchasesRelationManager::class,
            AssignmentsRelationManager::class,
            LicensesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
