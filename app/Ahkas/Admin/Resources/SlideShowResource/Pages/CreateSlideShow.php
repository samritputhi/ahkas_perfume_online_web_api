<?php

namespace App\Ahkas\Admin\Resources\SlideShowResource\Pages;

use App\Ahkas\Admin\Resources\SlideShowResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSlideShow extends CreateRecord
{
    protected static string $resource = SlideShowResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
