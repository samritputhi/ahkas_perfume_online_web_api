<?php

namespace App\Ahkas\Admin\Resources\PopularSearchResource\Pages;

use App\Ahkas\Admin\Resources\PopularSearchResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePopularSearch extends CreateRecord
{
    protected static string $resource = PopularSearchResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
