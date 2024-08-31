<?php

namespace App\Ahkas\Admin\Resources\PopularSearchResource\Pages;

use App\Ahkas\Admin\Resources\PopularSearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPopularSearch extends ViewRecord
{
    protected static string $resource = PopularSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
