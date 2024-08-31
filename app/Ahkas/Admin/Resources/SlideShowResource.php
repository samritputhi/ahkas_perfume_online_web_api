<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\SlideShowResource\Pages;
use App\Ahkas\Domain\SlideShow\SlideShowModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlideShowResource extends Resource
{
    protected static ?string $model = SlideShowModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-view-columns';

    protected static ?string $modelLabel = 'Slide Show List';

    protected static ?string $navigationLabel = 'Slide Show';

    protected static ?string $navigationGroup = 'Application';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->required(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('slide-show'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex(),

                TextColumn::make('name'),

                ImageColumn::make('image'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListSlideShows::route('/'),
            'create' => Pages\CreateSlideShow::route('/create'),
            'view' => Pages\ViewSlideShow::route('/{record}'),
            'edit' => Pages\EditSlideShow::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->orderBy('id', "DESC");
    }
}
