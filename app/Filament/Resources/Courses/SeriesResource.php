<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\SeriesResource\Pages\CreateSeries;
use App\Filament\Resources\Courses\SeriesResource\Pages\EditSeries;
use App\Filament\Resources\Courses\SeriesResource\Pages\ListSeries;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Series;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeriesResource extends Resource
{
    protected static ?string $model = Series::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Courses';

    protected static ?int $navigationSort = 2;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->maxFiles(1)
                    ->rules(['image'])
                    ->columnStart(1),
                TextInput::make('title')
                    ->columnStart(1)
                    ->disabled(),
                TextInput::make('slug')
                    ->columnStart(1)
                    ->disabled(),
                MarkdownEditor::make('description')
                    ->columnSpan(2),
                MarkdownEditor::make('introduction')
                    ->columnSpan(2),
                Toggle::make('visible')
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->searchable()->sortable(),
                ImageColumn::make('image'),
                BooleanColumn::make('visible'),
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
            'index' => ListSeries::route('/'),
            'create' => CreateSeries::route('/create'),
            'edit' => EditSeries::route('/{record}/edit'),
        ];
    }
}
