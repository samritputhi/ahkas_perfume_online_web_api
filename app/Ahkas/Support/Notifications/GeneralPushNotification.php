<?php

namespace App\Ahkas\Support\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class GeneralPushNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $message)
    {
        // $this->delay(Carbon::now()->addSecond(10));
    }


    public function via(mixed $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toFcm(): FcmMessage
    {

        return (new FcmMessage(notification: new FcmNotification(
            title: $this->message['title'],
            body: $this->message['body'],
            // image: 'http://example.com/url-to-image-here.png'
        )))
            ->data(['data1' => 'value', 'data2' => 'value2'])
            ->custom([
                'android' => [
                    'notification' => [
                        'color' => '#0A0A0A',
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
                'apns' => [
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'general_notification' => $this->message
        ];
    }
}
