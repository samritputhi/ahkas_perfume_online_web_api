<?php

namespace App\Ahkas\Domain\NotificationMessage\Observers;

use App\Ahkas\Domain\NotificationMessage\Enums\NotificationTypeEnum;
use App\Ahkas\Domain\NotificationMessage\Models\NotificationMessageModel;
use App\Ahkas\Domain\User\UserModel;
use App\Ahkas\Support\Notifications\GeneralPushNotification;

class NotificationMessageObserver
{

    public function created(NotificationMessageModel $notification)
    {
        $message = [
            'type' => 'general',
            'title' => $notification->title,
            'body' => $notification->notification
        ];

        if ($notification->type == NotificationTypeEnum::USER ) {
            $meta = json_decode($notification->meta, true);
            if (array_key_exists('user_id', $meta)) {
                $user = UserModel::find($meta['user_id']);
                $user->notificationMessages()->attach($notification->id);
                $user->notify(new GeneralPushNotification($message));
            }
        } else {
            $notification->users()->attach(UserModel::pluck('id'));
            $users = UserModel::all();
            foreach ($users as $user) {
                $user->notify(new GeneralPushNotification($message));
            }
        }
    }
}
