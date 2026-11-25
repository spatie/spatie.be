<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminAccessResource\Pages\ManageAdminAccess;
use App\Models\AdminAccess;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminAccessResource extends Resource
{
    protected static ?string $model = AdminAccess::class;

    protected static ?string $navigationLabel = 'Admin access';

    protected static ?string $modelLabel = 'address';

    protected static ?string $pluralModelLabel = 'Admin access';

    protected static string | \UnitEnum | null $navigationGroup = 'Team';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-key';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('email')
                ->label('Spatie email address')
                ->email()
                ->required()
                ->maxLength(255)
                ->mutateStateForValidationUsing(fn (?string $state): string => strtolower(trim($state ?? '')))
                ->dehydrateStateUsing(fn (string $state): string => strtolower(trim($state)))
                ->rules(['ends_with:@spatie.be'])
                ->validationMessages(['ends_with' => 'Use an @spatie.be email address.'])
                ->unique()
                ->helperText('They can sign in with Google as soon as you add their address. No invitation email is sent.'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->label('Email address')->searchable(),
            ])
            ->stackedOnMobile()
            ->defaultSort('email')
            ->paginated(false)
            ->recordActions([
                DeleteAction::make()
                    ->label('Remove access')
                    ->disabled(fn (): bool => AdminAccess::query()->count() <= 1)
                    ->tooltip(fn (): ?string => AdminAccess::query()->count() <= 1
                        ? 'Add another address before removing the last administrator.'
                        : null)
                    ->modalHeading(fn (AdminAccess $record): string => "Remove access for {$record->email}?")
                    ->modalDescription('They will lose admin access on their next request. Their regular account will not be deleted.')
                    ->modalSubmitActionLabel('Remove access')
                    ->using(fn (AdminAccess $record): bool => $record->revoke()),
            ])
            ->emptyStateHeading('No approved addresses')
            ->emptyStateDescription('Add a Spatie address to let someone sign in with Google.');
    }

    public static function getPages(): array
    {
        return ['index' => ManageAdminAccess::route('/')];
    }
}
