<?php

namespace App\Ahkas\Domain\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Ahkas\Domain\Cart\CartModel;
use App\Ahkas\Domain\NotificationMessage\Models\NotificationMessageModel;
use App\Ahkas\Domain\NotificationMessage\Models\NotificationMessageUserModel;
use App\Ahkas\Domain\Order\OrderModel;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes,
        UserRelationshipMixin;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'phone',
        'device_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cart(): HasOne
    {
        return $this->hasOne(CartModel::class, 'user_id', 'id');
    }


    public function notificationMessages(): BelongsToMany
    {
        return $this->belongsToMany(NotificationMessageModel::class, 'notification_message_users', 'user_id', 'notification_message_id',)
            ->using(NotificationMessageUserModel::class)
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function routeNotificationForFcm(): array
    {
        return $this->devices()->pluck('token')->toArray();
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
