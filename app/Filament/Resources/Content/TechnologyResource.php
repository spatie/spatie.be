<?php

namespace App\Filament\Resources\Content;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Content\TechnologyResource\Pages\ListTechnologies;
use App\Filament\Resources\Content\TechnologyResource\Pages\CreateTechnology;
use App\Filament\Resources\Content\TechnologyResource\Pages\EditTechnology;
use App\Filament\Resources\Content\TechnologyResource\Pages;
use App\Models\Enums\TechnologyType;
use App\Models\Member;
use App\Models\Technology;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-heart';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                TextInput::make('name')
                    ->columnStart(1)
                    ->required(),
                Textarea::make('description')
                    ->columnStart(1)
                    ->required(),
                Select::make('type')
                    ->options(TechnologyType::toLabels())
                    ->columnStart(1)
                    ->required(),
                TextInput::make('website_url')
                    ->columnStart(1)
                    ->required()
                    ->url(),
                Select::make('recommended_by')
                    ->options(Member::query()
                        ->pluck('first_name')
                        ->mapWithKeys(fn (string $name) => [strtolower($name) => strtolower($name)]))
                    ->columnStart(1)
                    ->multiple(),
                SpatieMediaLibraryFileUpload::make('avatar')
                    ->columnStart(1)
                    ->maxFiles(1)
                    ->rules(['image'])
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('type')->searchable()->sortable(),
                TextColumn::make('website_url')
                    ->url(fn ($record) => $record->website_url)
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('avatar'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
            'index' => ListTechnologies::route('/'),
            'create' => CreateTechnology::route('/create'),
            'edit' => EditTechnology::route('/{record}/edit'),
        ];
    }
}
