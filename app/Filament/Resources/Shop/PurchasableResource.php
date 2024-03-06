<?php

namespace App\Filament\Resources\Shop;

use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\Purchasable;
use App\Filament\Resources\Shop;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Wiebenieuwenhuis\FilamentCodeEditor\Components\CodeEditor;

class PurchasableResource extends Resource
{
    protected static ?string $model = Purchasable::class;

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')->columnSpan(2)->tabs([
                    Tab::make('Setup')->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('type')
                                    ->options(PurchasableType::getLabels())
                                    ->columnStart(1),

                                Select::make('renewal_purchasable_id')
                                    ->relationship(name: 'renewalPurchasable')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title . ' (' . $record->product->title . ')')
                                    ->columnStart(1),

                                Select::make('product_id')
                                    ->relationship(name: 'product')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title)
                                    ->columnStart(1),

                                TextInput::make('paddle_product_id')
                                    ->required()
                                    ->columnStart(1),

                                Toggle::make('released')
                                    ->columnStart(1),
                                Toggle::make('requires_license')
                                    ->columnStart(1),
                                Toggle::make('is_lifetime')
                                    ->columnStart(1),

                                TextInput::make('repository_access')
                                    ->nullable()
                                    ->columnStart(1),

                                Repeater::make('satis_packages')
                                    ->simple(TextInput::make('name')->required())
                                    ->columnStart(1),
                            ]),
                    ]),
                    Tab::make('Details')->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->columnStart(1),
                                SpatieMediaLibraryFileUpload::make('image')
                                    ->collection('purchasable-image')
                                    ->maxFiles(1)
                                    ->rules(['image'])
                                    ->columnStart(1),
                                TextInput::make('price_in_usd_cents')
                                    ->integer()
                                    ->required()
                                    ->columnStart(1),
                                TextInput::make('getting_started_url')
                                    ->required()
                                    ->columnStart(1),

                                TextInput::make('getting_started_url')
                                    ->columnStart(1),

                                CodeEditor::make('getting_started_description')
                                    ->columnSpan(2),

                                CodeEditor::make('extra_links')
                                    ->columnSpan(2),

                                MarkdownEditor::make('description')
                                    ->columnSpan(2),

                                MarkdownEditor::make('renewal_mail_incentive')
                                    ->columnSpan(2),
                            ]),
                    ]),
                    Tab::make('Discount')->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('discount_percentage')
                                    ->helperText('The discount percentage to be displayed.')
                                    ->columnStart(1),
                                TextInput::make('discount_name')
                                    ->helperText('The reason for the discount.')
                                    ->columnStart(1),
                                DateTimePicker::make('discount_starts_at')
                                    ->columnStart(1),
                                DateTimePicker::make('discount_expires_at')
                                    ->helperText('Not specifying this field will make the coupon active indefinitely'),
                            ]),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ResourceLinkColumn::make(
                    'product.title',
                    fn (Purchasable $record) => route('filament.admin.resources.shop.products.edit', ['record' => $record->product]),
                )->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                BooleanColumn::make('released')->sortable(),
                Tables\Columns\TextColumn::make('price_in_usd_cents')->sortable(),
                Tables\Columns\TextColumn::make('discount_percentage')->sortable(),
            ])
            ->filters([

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
            'index' => Shop\PurchasableResource\Pages\ListPurchasables::route('/'),
            'create' => Shop\PurchasableResource\Pages\CreatePurchasable::route('/create'),
            'edit' => Shop\PurchasableResource\Pages\EditPurchasable::route('/{record}/edit'),
        ];
    }
}
