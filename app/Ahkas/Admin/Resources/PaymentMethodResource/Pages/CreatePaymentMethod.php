<?php

namespace App\Ahkas\Admin\Resources\PaymentMethodResource\Pages;

use App\Ahkas\Admin\Resources\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentMethod extends CreateRecord
{
    protected static string $resource = PaymentMethodResource::class;
}
