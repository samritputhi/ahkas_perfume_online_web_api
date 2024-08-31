<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\ReceiveOrderResource\Pages;
use App\Ahkas\Admin\Resources\ReceiveOrderResource\RelationManagers\ItemsRelationManager;
use App\Ahkas\Admin\Resources\ReceiveOrderResource\RelationManagers\UserRelationManager;
use App\Ahkas\Admin\Resources\ReceiveOrderResource\Widgets\OrderStat;
use App\Ahkas\Domain\Order\enum\OrderStatusEnum;
use App\Ahkas\Domain\Order\OrderModel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReceiveOrderResource extends Resource
{
    protected static ?string $model = OrderModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Received Order';

    protected static ?string $navigationLabel = 'Received Order';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('order_number'),
                DateTimePicker::make('created_at'),
                TextInput::make('total_item_price')
                    ->prefix('USD')
                    ->label('total'),
                TextInput::make('total_item_price_after_discount')
                    ->prefix('USD')
                    ->label('total_after_discount'),
                TextInput::make('status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number'),
                TextColumn::make('user.name'),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('total_item_price')
                    ->summarize([
                        Sum::make()->money(),
                    ])
                    ->money()
                    ->label('total'),
                TextColumn::make('total_item_price_after_discount')
                    ->summarize([
                        Sum::make()->money(),
                    ])
                    ->money()
                    ->label('total_after_discount'),
                TextColumn::make('date')
                    ->datetime()
                    ->state(function (OrderModel $record): string {
                        if ($record->status == OrderStatusEnum::PENDING) {
                            return $record->created_at;
                        }
                        if ($record->status == OrderStatusEnum::CONFIRM) {
                            return $record->confirm_at ?? '';
                        }
                        if ($record->status == OrderStatusEnum::DELIVERY) {
                            return $record->delivery_at ?? '';
                        }
                        if ($record->status == OrderStatusEnum::RECEIVE) {
                            return $record->completed_at ?? '';
                        }
                        if ($record->status == OrderStatusEnum::RECEIVE) {
                            return $record->cancelled_at ?? '';
                        }
                        if ($record->status == OrderStatusEnum::REJECT) {
                            return $record->rejected_at ?? '';
                        }
                        return $record->created_at;
                    }),


            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceiveOrders::route('/'),
            'create' => Pages\CreateReceiveOrder::route('/create'),
            'view' => Pages\ViewReceiveOrder::route('/{record}'),
            'edit' => Pages\EditReceiveOrder::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderStat::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $modelClass = static::$model;
        return (string) $modelClass::where('status', OrderStatusEnum::PENDING)->count();
    }
}
