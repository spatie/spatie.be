<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\TechnologyResource\Pages;
use App\Models\Enums\TechnologyType;
use App\Models\Member;
use App\Models\Technology;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

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
                Textarea::make('description')
                    ->columnStart(1)
                    ->required(),
                Select::make('type')
                    ->options(TechnologyType::toLabels())
                    ->columnStart(1)
                    ->required(),
                TextInput::make('website_url')
                    ->columnStart(1)
                    ->required(),
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
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('website_url')->searchable()->sortable(),
                SpatieMediaLibraryImageColumn::make('avatar'),
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
            'index' => Pages\ListTechnologies::route('/'),
            'create' => Pages\CreateTechnology::route('/create'),
            'edit' => Pages\EditTechnology::route('/{record}/edit'),
        ];
    }
}
