<?php

namespace App\Filament\Resources\Content;

use App\Console\Commands\ImportGitHubRepositoriesCommand;
use App\Filament\Resources\Content\RepositoryResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Models\Repository;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

class RepositoryResource extends Resource
{
    protected static ?string $model = Repository::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                TextInput::make('name')
                    ->columnStart(1)
                    ->required(),
                Select::make('ad_id')
                    ->relationship(name: 'ad')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->columnStart(1),
                Toggle::make('ad_should_be_randomized')
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                ResourceLinkColumn::make(
                    'ad.name',
                    function (Repository $record) {
                        if (! $record->ad) {
                            return null;
                        }

                        return route('filament.admin.resources.content.ads.edit', ['record' => $record->ad]);
                    },
                )->openUrlInNewTab(),
                BooleanColumn::make('ad_should_be_randomized'),
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
            ])
            ->headerActions([
                Tables\Actions\Action::make('Import docs')
                    ->button()
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn() => dispatch(fn () =>
                        Artisan::call(ImportGitHubRepositoriesCommand::class)
                    ))
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
            'index' => Pages\ListRepositories::route('/'),
            'create' => Pages\CreateRepository::route('/create'),
            'edit' => Pages\EditRepository::route('/{record}/edit'),
        ];
    }
}
