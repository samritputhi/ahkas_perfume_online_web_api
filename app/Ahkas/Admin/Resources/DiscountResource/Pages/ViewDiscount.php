<?php

namespace App\Ahkas\Admin\Resources\DiscountResource\Pages;

use App\Ahkas\Admin\Resources\DiscountResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDiscount extends ViewRecord
{
    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
