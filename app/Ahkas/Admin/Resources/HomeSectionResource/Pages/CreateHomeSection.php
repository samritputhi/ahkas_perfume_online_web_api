<?php

namespace App\Ahkas\Admin\Resources\HomeSectionResource\Pages;

use App\Ahkas\Admin\Resources\HomeSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomeSection extends CreateRecord
{
    protected static string $resource = HomeSectionResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
