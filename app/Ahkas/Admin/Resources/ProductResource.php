<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\ProductResource\Pages;
use App\Ahkas\Domain\Product\ProductModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = ProductModel::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-s-rectangle-stack';

    protected static ?string $modelLabel = 'Product List';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->description('please fill product info')
                    ->schema([
                        Group::make()
                            ->columns(['default' => 3,])
                            ->schema([
                                TextInput::make('name')->required(),
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->required(),
                                Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->required(),
                            ]),
                        Textarea::make('description')->required(),
                    ]),

                Section::make()
                    ->description('please update product image')
                    ->schema([
                        FileUpload::make('image')
                            ->required()
                            ->image()
                            ->multiple()
                            ->previewable()
                            ->panelLayout('grid')
                            ->directory('product'),
                    ]),
                Section::make()
                    ->description('product option')
                    ->schema([
                        Repeater::make('prices')
                            ->relationship('prices')
                            ->minItems(1)
                            ->maxItems(5)
                            ->schema([
                                Group::make()->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('price')
                                        ->prefix('$')->required(),
                                ]),

                                FileUpload::make('image')
                                    ->image()
                                    ->previewable()
                                    ->directory('product/thumnail')
                                    ->imageResizeTargetWidth('200')
                                    ->imageResizeTargetHeight('200')
                                    ->imagePreviewHeight('125'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('category.name'),
                TextColumn::make('brand.name'),
                TextColumn::make('name'),
                TextColumn::make('description'),
                TextColumn::make('original_price'),
                TextColumn::make('compare_price'),
                TextColumn::make('discount_label')
                    ->formatStateUsing(function (ProductModel $model) {
                        return  $model->has_discount ? $model->discount_label : '';
                    })
                    ->badge(),
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
            // ProductRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->orderBy('id', 'DESC');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'brand.name', 'category.name'];
    }
}
