<?php

namespace App\Ahkas\Application\Cart;

use App\Ahkas\Admin\Resources\ReceiveOrderResource;
use App\Ahkas\Domain\Order\actions\CreateOrder;
use App\Ahkas\Domain\Order\OrderModel;
use App\Ahkas\Domain\User\UserAdminModel;
use App\Ahkas\Domain\User\UserModel;
use App\Ahkas\Support\Telegram\Telegram;
use Exception;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Throwable;

use function App\Ahkas\Support\asJson;

class CartCheckOutController
{

    /**
     * @throws Throwable
     */
    public function __invoke(UserModel $user, Request $request): JsonResponse
    {

        if (is_null($user->cart)) return asJson('Not available items in cart.', 400);

        DB::beginTransaction();

        try {

            $order = (new CreateOrder)(
                $user->cart,
                $request->payment ?? 'none',
                $request->address ?? 'none',
            );

            DB::commit();

            $this->sentTelegram($order);
            $this->sentToAdmin($order);

            return asJson([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function sentTelegram(OrderModel $order)
    {
        $text = "----- Received New Order -----\n"
            . "User:\t{$order->user->name}\n"
            . "Amount:\t" . $order->total_item_price_after_discount . "\n";

        Telegram::send()->text($text);
    }

    private function sentToAdmin(OrderModel $order)
    {
        Notification::make()
            ->title('New order')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$order->user->name} ordered {$order->items->count()} products.**")
            ->actions([
                Action::make('View')
                    ->url(ReceiveOrderResource::getUrl() . '/' . $order->id),
            ])
            ->sendToDatabase(UserAdminModel::find(1));
    }
}
