<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\UserResource\Actions\TransferPurchaseAssignmentAction;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Customers';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('uuid')
                            ->label('UUID')
                            ->maxLength(36)
                            ->disabled(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnStart(1),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnStart(1),
                        Forms\Components\TextInput::make('github_id')
                            ->columnStart(1)
                            ->numeric(),
                        Forms\Components\TextInput::make('github_username')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_sponsor')
                            ->disabled()
                            ->columnStart(1),
                        Forms\Components\Toggle::make('is_admin')
                            ->columnStart(1)
                            ->required(),
                        Forms\Components\Toggle::make('has_access_to_unreleased_products')
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

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('github_username')
                    ->searchable(),

                BooleanColumn::make('is_sponsor')->default(false),
                BooleanColumn::make('is_admin'),
                BooleanColumn::make('has_access_to_unreleased_products'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    TransferPurchaseAssignmentAction::make(),
                ]),
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
            'index' => \App\Filament\Resources\Customers\UserResource\Pages\ListUsers::route('/'),
            'create' => \App\Filament\Resources\Customers\UserResource\Pages\CreateUser::route('/create'),
            'edit' => \App\Filament\Resources\Customers\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
