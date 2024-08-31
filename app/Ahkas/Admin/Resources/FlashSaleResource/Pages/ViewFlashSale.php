<?php

namespace App\Ahkas\Admin\Resources\FlashSaleResource\Pages;

use App\Ahkas\Admin\Resources\FlashSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFlashSale extends ViewRecord
{
    protected static string $resource = FlashSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
