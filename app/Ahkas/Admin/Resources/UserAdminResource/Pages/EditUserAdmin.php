<?php

namespace App\Ahkas\Admin\Resources\UserAdminResource\Pages;

use App\Ahkas\Admin\Resources\UserAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserAdmin extends EditRecord
{
    protected static string $resource = UserAdminResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
