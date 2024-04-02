<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\AdResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Ad;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                FileUpload::make('image')
                    ->disk('github_ads')
                    ->columnStart(1),
                TextInput::make('name')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('click_redirect_url')
                    ->columnStart(1)
                    ->required(),
                Toggle::make('active')
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                ImageColumn::make('image')->disk('github_ads'),
                Tables\Columns\TextColumn::make('click_redirect_url')
                    ->url(fn ($record) => $record->click_redirect_url)
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('active'),
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
