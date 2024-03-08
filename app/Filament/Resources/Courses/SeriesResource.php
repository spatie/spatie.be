<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\SeriesResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Series;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeriesResource extends Resource
{
    protected static ?string $model = Series::class;

    protected static ?string $navigationGroup = 'Courses';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                BooleanColumn::make('visible'),
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
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSeries::route('/create'),
            'edit' => Pages\EditSeries::route('/{record}/edit'),
        ];
    }
}
