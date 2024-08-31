<?php

namespace App\Ahkas\Domain\NotificationMessage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @author SOPHEAK
 */
class NotificationMessageUserModel extends Pivot
{

    protected $table = 'notification_message_users';

    protected $guarded = [];


    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
