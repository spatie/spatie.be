<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\SeriesResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Series;
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
                //
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
