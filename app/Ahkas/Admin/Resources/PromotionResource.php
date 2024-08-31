<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\PromotionResource\Pages;
use App\Ahkas\Domain\Product\ProductModel;
use App\Ahkas\Domain\Promotion\PromotionModel;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class PromotionResource extends Resource
{
    protected static ?string $model = PromotionModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-ticket';

    protected static ?string $modelLabel = 'Promotion List';

    protected static ?string $navigationLabel = 'Promotion';

    protected static ?string $navigationGroup = 'Promotion';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Group::make()->schema([
                            TextInput::make('name')
                                ->required(),
                            Textarea::make('description')
                                ->required(),
                        ]),

                        Group::make()->schema([
                            DateTimePicker::make('issued_at')
                                ->required()
                                ->default(Carbon::now()),
                            DateTimePicker::make('expired_at')
                                ->required()
                        ]),
                    ]),

                // ---- repeater ----

                Section::make()
                    ->schema([Repeater::make('rules')
                        ->relationship()
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Group::make()
                                        ->schema([Section::make()
                                            ->description('buy')
                                            ->columns(2)
                                            ->schema([
                                                Select::make('product_id')
                                                    ->options(ProductModel::all()->pluck('name', 'id'))
                                                    ->required(),
                                                TextInput::make('required_quantity')
                                                    ->numeric()
                                                    ->required(),
                                            ]),]),
                                    Group::make()->schema([Section::make()
                                        ->description('get')
                                        ->columns(2)
                                        ->schema([
                                            Select::make('free_product_id')
                                                ->options(ProductModel::all()->pluck('name', 'id'))
                                                ->required(),
                                            TextInput::make('free_quantity')
                                                ->numeric()
                                                ->required(),
                                        ]),]),


                                ]),




                        ])]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('description'),
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
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'view' => Pages\ViewPromotion::route('/{record}'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }
}
