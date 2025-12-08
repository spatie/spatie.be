<?php

namespace App\Filament\Resources\Content;

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Release;
use App\Filament\Resources\Content\ReleaseResource\Pages\CreateRelease;
use App\Filament\Resources\Content\ReleaseResource\Pages\EditRelease;
use App\Filament\Resources\Content\ReleaseResource\Pages\ListReleases;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReleaseResource extends Resource
{
    protected static ?string $model = Release::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                Select::make('product_id')
                    ->relationship(name: 'product')
                    ->getOptionLabelFromRecordUsing(fn (Product $record) => $record->title)
                    ->columnStart(1),
                TextInput::make('version')
                    ->columnStart(1)
                    ->required(),
                Toggle::make('released')
                    ->columnStart(1),
                DateTimePicker::make('released_at')
                    ->columnStart(1)
                    ->required(),
                MarkdownEditor::make('notes')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                ResourceLinkColumn::make(
                    'product.title',
                    fn (Release $record) => route('filament.admin.resources.shop.products.edit', ['record' => $record->product])
                ),
                TextColumn::make('version')->searchable()->sortable(),
                BooleanColumn::make('released'),
                TextColumn::make('released_at')->dateTime()->sortable(),
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
            'index' => ListReleases::route('/'),
            'create' => CreateRelease::route('/create'),
            'edit' => EditRelease::route('/{record}/edit'),
        ];
    }
}
