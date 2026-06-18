<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\RepositoryReleaseResource\Pages\ListRepositoryReleases;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\RepositoryRelease;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RepositoryReleaseResource extends Resource
{
    protected static ?string $model = RepositoryRelease::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $recordTitleAttribute = 'tag_name';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('released_at', 'desc')
            ->columns([
                TextColumn::make('repository.name')
                    ->label('Package')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tag_name')
                    ->label('Version')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Title')
                    ->limit(50)
                    ->toggleable(),
                BooleanColumn::make('is_release')
                    ->label('Release'),
                BooleanColumn::make('is_prerelease')
                    ->label('Pre-release')
                    ->toggleable(),
                TextColumn::make('released_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordUrl(fn (RepositoryRelease $record) => $record->url)
            ->openRecordUrlInNewTab();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRepositoryReleases::route('/'),
        ];
    }
}
