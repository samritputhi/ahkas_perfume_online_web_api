<?php

namespace App\Ahkas\Admin\Resources\UserAdminResource\Pages;

use App\Ahkas\Admin\Resources\UserAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserAdmin extends CreateRecord
{
    protected static string $resource = UserAdminResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
