<?php

namespace App\Ahkas\Admin\Resources\SlideShowResource\Pages;

use App\Ahkas\Admin\Resources\SlideShowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlideShows extends ListRecords
{
    protected static string $resource = SlideShowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
