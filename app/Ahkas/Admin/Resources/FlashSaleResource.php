<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\FlashSaleResource\Pages;
use App\Ahkas\Admin\Resources\FlashSaleResource\RelationManagers;
use App\Ahkas\Domain\FlashSale\FlashSaleModel;
use App\Ahkas\Domain\FlashSale\FlashSaleProductModel;
use App\Ahkas\Domain\Product\ProductModel;
use App\Models\FlashSale;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Clue\StreamFilter\fun;

class FlashSaleResource extends Resource
{
    protected static ?string $model = FlashSaleModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-bolt';

    protected static ?string $modelLabel = 'Flash Sale';

    protected static ?string $navigationLabel = 'Flash Sale';

    protected static ?string $navigationGroup = 'Promotion';

    public static function canCreate(): bool
    {
        $allStatusTrue = FlashSaleModel::all()->every(function ($item) {
            return $item->isExpired === true;
        });
        return $allStatusTrue;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->description('please fill product info')
                    ->schema([
                        TextInput::make('name')->required(),

                        Select::make('product')
                            ->multiple()
                            ->required()
                            ->relationship('products', 'name'),
                        Section::make()
                            ->columns(['default' => 2])
                            ->schema([
                                DateTimePicker::make('issued_at')
                                    ->required()
                                    ->default(Carbon::now()),
                                DateTimePicker::make('expired_at')
                                    ->required()
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex(),
                TextColumn::make('name'),
                TextColumn::make('issued_at')->dateTime(),
                TextColumn::make('expired_at')->dateTime(),
                TextColumn::make('id')
                    ->label('status')
                    ->formatStateUsing(function (FlashSaleModel $model): string {
                        return $model->status;
                    })
                    ->badge()
                    ->color(function (FlashSaleModel $model): String {
                        if ($model->status == 'pending') {
                            return 'info';
                        }
                        if ($model->status == 'active') {
                            return 'success';
                        }
                        if ($model->status == 'expired') {
                            return 'danger';
                        }
                    }),
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
            'index' => Pages\ListFlashSales::route('/'),
            'create' => Pages\CreateFlashSale::route('/create'),
            'view' => Pages\ViewFlashSale::route('/{record}'),
            'edit' => Pages\EditFlashSale::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('id', 'DESC');
    }
}
