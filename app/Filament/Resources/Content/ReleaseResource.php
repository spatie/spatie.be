<?php

namespace App\Filament\Resources\Content;

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Release;
use App\Filament\Resources\Content\ReleaseResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReleaseResource extends Resource
{
    protected static ?string $model = Release::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                ResourceLinkColumn::make(
                    'product.title',
                    fn (Release $record) => route('filament.admin.resources.shop.products.edit', ['record' => $record->product])
                ),
                Tables\Columns\TextColumn::make('version')->searchable()->sortable(),
                BooleanColumn::make('released'),
                Tables\Columns\TextColumn::make('released_at')->dateTime()->sortable(),
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
            'index' => Pages\ListReleases::route('/'),
            'create' => Pages\CreateRelease::route('/create'),
            'edit' => Pages\EditRelease::route('/{record}/edit'),
        ];
    }
}
