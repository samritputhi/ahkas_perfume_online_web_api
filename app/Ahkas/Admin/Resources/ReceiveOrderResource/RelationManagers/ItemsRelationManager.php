<?php

namespace App\Ahkas\Admin\Resources\ReceiveOrderResource\RelationManagers;

use App\Ahkas\Domain\Order\OrderItemModel;
use App\Ahkas\Domain\Product\ProductModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                // Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('product.image'),
                Tables\Columns\TextColumn::make('product.name'),
                Tables\Columns\TextColumn::make('qty'),
                Tables\Columns\TextColumn::make('total_item_price'),
                Tables\Columns\TextColumn::make('total_item_price_after_discount'),
                Tables\Columns\TextColumn::make('options'),
                Tables\Columns\TextColumn::make('id')
                    ->state(function (OrderItemModel $model) {
                        if ($model->qty == 1)
                            return 'free ' . $model->product->name . ' +1';
                        return '';
                    })
                    ->label('promotion')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
