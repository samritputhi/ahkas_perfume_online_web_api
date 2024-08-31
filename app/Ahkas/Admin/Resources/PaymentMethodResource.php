<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\PaymentMethodResource\Pages;
use App\Ahkas\Admin\Resources\PaymentMethodResource\RelationManagers;
use App\Ahkas\Domain\PaymentMethod\PaymentMethodModel;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethodModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-credit-card';

    protected static ?string $modelLabel = 'Payment Method List';

    protected static ?string $navigationLabel = 'Payment Method';

    protected static ?string $navigationGroup = 'Application';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('bank')
                        ->options([
                            'aba' => 'ABA',
                            'aclida' => 'ACLIDA',
                            'wing' => 'WING',
                        ]),

                    TextInput::make('account_holder'),

                    TextInput::make('account_number'),
                    TextInput::make('url'),
                    Textarea::make('description'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->rowIndex(),

                TextColumn::make('bank'),

                TextColumn::make('account_holder'),

                TextColumn::make('account_number'),

                TextColumn::make('description'),

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
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'view' => Pages\ViewPaymentMethod::route('/{record}'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
