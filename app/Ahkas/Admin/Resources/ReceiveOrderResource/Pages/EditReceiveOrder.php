<?php

namespace App\Ahkas\Admin\Resources\ReceiveOrderResource\Pages;

use App\Ahkas\Admin\Resources\ReceiveOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceiveOrder extends EditRecord
{
    protected static string $resource = ReceiveOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
