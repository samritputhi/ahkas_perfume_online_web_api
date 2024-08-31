<?php

namespace App\Ahkas\Domain\NotificationMessage\Models;

use App\Ahkas\Domain\NotificationMessage\Enums\NotificationTypeEnum;
use App\Ahkas\Domain\NotificationMessage\Observers\NotificationMessageObserver;
use App\Ahkas\Domain\User\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @author SOPHEAK
 */
class NotificationMessageModel extends Model
{
    use HasFactory;

    protected $table = 'notification_messages';

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'publish_at'
    ];

    protected $casts = [
        'type' => NotificationTypeEnum::class,
        'publish_at' => 'date:d-m-Y h:i A',
    ];

    // protected static function newFactory(): AddressFactory
    // {
    //     return AddressFactory::new();
    // }

    protected static function booted()
    {
        static::observe(NotificationMessageObserver::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'notification_message_users', 'notification_message_id', 'user_id')
            ->using(NotificationMessageUserModel::class)
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
