<?php

namespace App\Filament\Resources\Content;

use App\Filament\Resources\Content\MemberResource\Pages;
use App\Filament\Tables\Columns\BooleanColumn;
use App\Models\Member;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationGroup = 'Members';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->columnStart(1)
                    ->disabled(),
                TextInput::make('first_name')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('preferred_name')
                    ->columnStart(1),
                TextInput::make('role')
                    ->columnStart(1)
                    ->required(),
                Textarea::make('description')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->columnStart(1)
                    ->required(),
                Toggle::make('public_email')
                    ->required(),
                DatePicker::make('birthday')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('twitter')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('github')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('website')
                    ->columnStart(1)
                    ->required(),
                TextInput::make('website_rss')
                    ->columnStart(1)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                ImageColumn::make('avatar')
                    ->default(fn (Member $record) => gravatar_url($record->email)),
                Tables\Columns\TextColumn::make('first_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('last_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('preferred_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                BooleanColumn::make('public_email')->sortable(),
                Tables\Columns\TextColumn::make('birthday')->date()->sortable(),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
