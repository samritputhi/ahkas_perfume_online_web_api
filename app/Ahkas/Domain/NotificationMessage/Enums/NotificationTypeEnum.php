<?php

namespace App\Ahkas\Domain\NotificationMessage\Enums;

enum NotificationTypeEnum: string
{
    case GENERAL = 'general';
    case PROMOTION = 'promotion';
    case ORDER = 'order';
    case USER = 'user';
}
