<?php

namespace App\Ahkas\Support\Enums;

use Filament\Support\Contracts\HasLabel;

enum DiscountType: string implements HasLabel
{
    case FIXED_AMOUNT = 'fixed_amount';
    case PERCENTAGE = 'percentage';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
