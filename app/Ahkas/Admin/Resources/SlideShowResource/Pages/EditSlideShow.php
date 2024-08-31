<?php

namespace App\Ahkas\Admin\Resources\SlideShowResource\Pages;

use App\Ahkas\Admin\Resources\SlideShowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlideShow extends EditRecord
{
    protected static string $resource = SlideShowResource::class;

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
