<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\AdResource\Pages\CreateAd;
use App\Filament\Resources\Content\AdResource\Pages\EditAd;
use App\Filament\Resources\Content\AdResource\Pages\ListAds;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Ad;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->required()
                    ->url(),
                Toggle::make('active')
                    ->columnStart(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                ImageColumn::make('image')->disk('github_ads'),
                TextColumn::make('click_redirect_url')
                    ->url(fn ($record) => $record->click_redirect_url)
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('active'),
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
            'index' => ListAds::route('/'),
            'create' => CreateAd::route('/create'),
            'edit' => EditAd::route('/{record}/edit'),
        ];
    }
}
