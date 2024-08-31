<?php

namespace App\Ahkas\Admin\Resources\PopularSearchResource\Pages;

use App\Ahkas\Admin\Resources\PopularSearchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPopularSearch extends EditRecord
{
    protected static string $resource = PopularSearchResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
