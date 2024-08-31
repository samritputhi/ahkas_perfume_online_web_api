<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\HomeSectionResource\Pages;
use App\Ahkas\Domain\HomeSection\HomeSectionModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeSectionResource extends Resource
{
    protected static ?string $model = HomeSectionModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-home';

    protected static ?string $modelLabel = 'Home Section';

    protected static ?string $navigationLabel = 'Home Section';

    protected static ?string $navigationGroup = 'Application';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->description('please fill product info')
                    ->schema([
                        Group::make()
                            ->columns(2)
                            ->schema([
                                Group::make()
                                    ->schema([
                                        TextInput::make('title')
                                            ->required(),
                                        Radio::make('layout')
                                            ->label('Layout Display')
                                            ->options([
                                                'single' => 'Single Row', 'double' => 'Double Row'
                                            ])
                                            ->required()
                                            ->inline()
                                    ]),

                                FileUpload::make('banner')
                                    ->image()
                                    ->previewable()
                                    ->directory('banner'),
                            ]),
                    ]),
                Section::make()
                    ->description('please select product list')
                    ->schema([
                        Select::make('product')
                            ->multiple()
                            ->relationship('products', 'name')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex(),
                TextColumn::make('title'),
                TextColumn::make('layout'),
                ImageColumn::make('banner'),
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
            'index' => Pages\ListHomeSections::route('/'),
            'create' => Pages\CreateHomeSection::route('/create'),
            'view' => Pages\ViewHomeSection::route('/{record}'),
            'edit' => Pages\EditHomeSection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('id', 'DESC');
    }
}
