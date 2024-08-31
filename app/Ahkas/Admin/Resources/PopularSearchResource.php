<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\PopularSearchResource\Pages;
use App\Ahkas\Admin\Resources\PopularSearchResource\RelationManagers;
use App\Ahkas\Domain\Search\PopularSearchModel;
use App\Models\PopularSearch;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PopularSearchResource extends Resource
{
    protected static ?string $model = PopularSearchModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-magnifying-glass';

    protected static ?string $modelLabel = 'Popular Search';

    protected static ?string $navigationLabel = 'Popular Search';

    protected static ?string $navigationGroup = 'Application';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->description('popular search info')
                    ->schema([
                        TextInput::make('search_text')->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex(),
                TextColumn::make('search_text'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPopularSearches::route('/'),
            'create' => Pages\CreatePopularSearch::route('/create'),
            'view' => Pages\ViewPopularSearch::route('/{record}'),
            'edit' => Pages\EditPopularSearch::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('id', 'DESC');
    }
}
