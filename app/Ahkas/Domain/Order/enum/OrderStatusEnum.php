<?php

namespace App\Ahkas\Domain\Order\enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatusEnum: string implements HasIcon, HasColor, HasLabel
{
    case PENDING = 'pending';
    case CONFIRM = 'confirm';
    case DELIVERY = 'delivery';
    case RECEIVE = 'receive';
    case CANCEL = 'cancel';
    case REJECT = 'reject';



    public function getIcon(): ?String
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-information-circle',
            self::CONFIRM => 'heroicon-m-check-circle',
            self::DELIVERY => 'heroicon-m-truck',
            self::RECEIVE => 'heroicon-m-archive-box',
            self::CANCEL => 'heroicon-m-exclamation-triangle',
            self::REJECT => 'heroicon-m-x-circle',
        };
    }

    public function getColor(): ?String
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::CONFIRM => 'info',
            self::DELIVERY => 'info',
            self::RECEIVE => 'success',
            self::CANCEL => 'danger',
            self::REJECT => 'danger',
        };
    }

    public function getLabel(): ?String
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRM => 'Confirm',
            self::DELIVERY => 'Delivering',
            self::RECEIVE => 'Received',
            self::CANCEL => 'Cancelled',
            self::REJECT => 'Rejected',
        };
    }
}
