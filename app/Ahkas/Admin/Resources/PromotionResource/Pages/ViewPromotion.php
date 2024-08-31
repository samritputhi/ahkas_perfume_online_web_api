<?php

namespace App\Ahkas\Admin\Resources\PromotionResource\Pages;

use App\Ahkas\Admin\Resources\PromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPromotion extends ViewRecord
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
