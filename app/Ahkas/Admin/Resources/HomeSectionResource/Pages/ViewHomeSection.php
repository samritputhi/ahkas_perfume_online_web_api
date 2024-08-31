<?php

namespace App\Ahkas\Admin\Resources\HomeSectionResource\Pages;

use App\Ahkas\Admin\Resources\HomeSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHomeSection extends ViewRecord
{
    protected static string $resource = HomeSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
