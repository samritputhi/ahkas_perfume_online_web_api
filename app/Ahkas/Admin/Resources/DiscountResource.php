<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\DiscountResource\Pages;
use App\Ahkas\Domain\Brand\BrandModel;
use App\Ahkas\Domain\Category\CategoryModel;
use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\Discount\DiscountModel;
use App\Ahkas\Support\Enums\DiscountType;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DiscountResource extends Resource
{
    protected static ?string $model = DiscountModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-receipt-percent';

    protected static ?string $modelLabel = 'Discount List';

    protected static ?string $navigationLabel = 'Discounts';

    protected static ?string $navigationGroup = 'Promotion';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()
                    ->columns(['default' => 2])
                    ->schema([
                        MorphToSelect::make('discountable')
                            ->required()
                            ->label('Discount On')
                            ->types([
                                Type::make(BrandModel::class,)
                                    ->titleAttribute('name')
                                    ->label('Brand'),
                                Type::make(CategoryModel::class)
                                    ->titleAttribute('name')
                                    ->label('Category'),
                                Type::make(ProductModel::class)
                                    ->titleAttribute('name')
                                    ->label('Product'),
                            ]),
                        Group::make()
                            ->schema([
                                Select::make('type')
                                    ->required()
                                    ->live()
                                    ->options(DiscountType::class),
                                TextInput::make('amount')
                                    ->required()

                            ]),
                    ]),
                Section::make()
                    ->columns(['default' => 2])
                    ->schema([
                        DateTimePicker::make('issued_at')
                            ->default(Carbon::now()),
                        DateTimePicker::make('expired_at')
                            ->required()
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex(),
                TextColumn::make('discountable.name'),
                TextColumn::make('amount')
                    ->formatStateUsing(function (DiscountModel $model) {
                        $amount = $model->amount;
                        return  $model->type == DiscountType::PERCENTAGE ? $amount . ' %' : $amount . ' $';
                    }),
                TextColumn::make('issued_at')
                    ->dateTime(),
                TextColumn::make('expired_at')
                    ->dateTime(),
                TextColumn::make('active')
                    ->formatStateUsing(fn (bool $state): string => __($state ? 'active' : 'in_active'))
                    ->badge()
                    ->color(fn (bool $state): String => match ($state) {
                        true => 'success',
                        false => 'warning',
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
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'view' => Pages\ViewDiscount::route('/{record}'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('id', 'DESC');
    }
}
