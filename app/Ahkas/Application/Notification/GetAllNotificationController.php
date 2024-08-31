<?php

namespace App\Ahkas\Application\Notification;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Http\Request;

use function App\Ahkas\Support\asPagination;

class GetAllNotificationController
{
    private $fields = [
        'id',
        'title',
        'type',
        'notification',
        'notification_messages.created_at',
    ];
    public function __invoke(Request $request, UserModel $user)
    {
        $datas = $user->notificationMessages()
            ->select($this->fields)
            ->orderBy('id', 'DESC')
            ->paginate(perPage: $request->per_page)
            ->through(function ($notification) {
                $notification->read_at = $notification->pivot->read_at;
                $notification->publish_at_human = $notification->publish_at->diffForHumans();
                $notification->makeHidden(['created_at', 'pivot']);
                return $notification;
            });

        return asPagination($datas);
    }
}
