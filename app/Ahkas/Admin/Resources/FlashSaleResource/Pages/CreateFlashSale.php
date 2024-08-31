<?php

namespace App\Ahkas\Admin\Resources\FlashSaleResource\Pages;

use App\Ahkas\Admin\Resources\FlashSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlashSale extends CreateRecord
{
    protected static string $resource = FlashSaleResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
