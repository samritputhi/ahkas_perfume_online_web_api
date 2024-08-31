<?php

namespace App\Ahkas\Admin\Resources\NotificationMessageResource\Pages;

use App\Ahkas\Admin\Resources\NotificationMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificationMessage extends EditRecord
{
    protected static string $resource = NotificationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
