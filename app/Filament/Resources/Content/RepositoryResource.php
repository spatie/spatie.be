<?php

namespace App\Filament\Resources\Content;

use App\Console\Commands\ImportGitHubRepositoriesCommand;
use App\Filament\Resources\Content\RepositoryResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Filament\Tables\Columns\ResourceLinkColumn;
use App\Models\Repository;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\HtmlString;
use Spatie\Ssh\Ssh;

class RepositoryResource extends Resource
{
    protected static ?string $model = Repository::class;

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

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
                TextInput::make('documentation_url')
                    ->columnStart(1),
                TextInput::make('blogpost_url')
                    ->columnStart(1),
                Select::make('ad_id')
                    ->relationship(name: 'ad')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->columnStart(1),
                Toggle::make('ad_should_be_randomized')
                    ->columnStart(1),
                Section::make()->schema([
                    ColorPicker::make('accent_color')
                        ->columnStart(1),
                    Textarea::make('logo_svg')
                        ->rows(5)
                        ->columnStart(1),
                    Placeholder::make('dark_github_header')
                        ->columnStart(1)
                        ->content(fn ($record) => $record ? $record->darkGithubHeader() : null),
                    Placeholder::make('dark_github_header_preview')
                        ->label('')
                        ->content(fn ($record) => new HtmlString("<img src=\"{$record->darkGithubHeader()}\" alt=\"Dark GitHub header preview\">")),
                    Placeholder::make('light_github_header')
                        ->columnStart(1)
                        ->content(fn ($record) => $record ? $record->lightGithubHeader() : null),
                    Placeholder::make('light_github_header_preview')
                        ->label('')
                        ->content(fn ($record) => new HtmlString("<img src=\"{$record->lightGithubHeader()}\" alt=\"Dark GitHub header preview\">")),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                ResourceLinkColumn::make(
                    'ad.name',
                    function (Repository $record) {
                        if (! $record->ad) {
                            return null;
                        }

                        return route('filament.admin.resources.content.ads.edit', ['record' => $record->ad]);
                    },
                )->openUrlInNewTab(),
                BooleanColumn::make('ad_should_be_randomized'),
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
            ])
            ->headerActions([
                Tables\Actions\Action::make('Import docs')
                    ->button()
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn () => dispatch(
                        fn () =>
                        Artisan::call(ImportGitHubRepositoriesCommand::class)
                    )),
                Tables\Actions\Action::make('Update Satis')
                    ->button()
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn () => dispatch(function () {
                        Ssh::create('forge', 'satis.spatie.be')->execute([
                            'cd satis.spatie.be',
                            './bin/satis build',
                        ]);
                    })),
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
            'index' => Pages\ListRepositories::route('/'),
            'create' => Pages\CreateRepository::route('/create'),
            'edit' => Pages\EditRepository::route('/{record}/edit'),
        ];
    }
}
