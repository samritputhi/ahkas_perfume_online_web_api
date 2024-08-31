<?php

namespace App\Ahkas\Admin\Resources\PopularSearchResource\Pages;

use App\Ahkas\Admin\Resources\PopularSearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPopularSearches extends ListRecords
{
    protected static string $resource = PopularSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
