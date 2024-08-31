<?php

namespace App\Ahkas\Admin\Resources;

use App\Ahkas\Admin\Resources\NotificationMessageResource\Pages;
use App\Ahkas\Admin\Resources\NotificationMessageResource\RelationManagers;
use App\Ahkas\Domain\NotificationMessage\Enums\NotificationTypeEnum;
use App\Ahkas\Domain\NotificationMessage\Models\NotificationMessageModel;
use App\Models\NotificationMessage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
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

class NotificationMessageResource extends Resource
{
    protected static ?string $model = NotificationMessageModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-bell-alert';

    protected static ?string $modelLabel = 'Notification';

    protected static ?string $navigationLabel = 'Notification';

    protected static ?string $navigationGroup = 'Promotion';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options([
                        'general' => "GENERAL",
                        'promotion' => "PROMOTION",
                    ]),
                TextInput::make('title')->required(),
                Textarea::make('notification')->required(),
                DateTimePicker::make('publish_at')
                    ->default(Carbon::now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type'),
                TextColumn::make('title'),
                TextColumn::make('notification'),
                TextColumn::make('publish_at')
                    ->dateTime(),
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
            'index' => Pages\ListNotificationMessages::route('/'),
            'create' => Pages\CreateNotificationMessage::route('/create'),
            'view' => Pages\ViewNotificationMessage::route('/{record}'),
            'edit' => Pages\EditNotificationMessage::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', '!=', 'user');
    }
}
