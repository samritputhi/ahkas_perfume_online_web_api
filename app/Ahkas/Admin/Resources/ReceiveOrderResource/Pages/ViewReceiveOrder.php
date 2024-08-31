<?php

namespace App\Ahkas\Admin\Resources\ReceiveOrderResource\Pages;

use App\Ahkas\Admin\Resources\ReceiveOrderResource;
use App\Ahkas\Admin\Resources\ReceiveOrderResource\Widgets\OrderStat;
use App\Ahkas\Domain\Order\enum\OrderStatusEnum;
use App\Ahkas\Domain\Order\OrderModel;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewReceiveOrder extends ViewRecord
{
    protected static string $resource = ReceiveOrderResource::class;

    private function getLabel(): string
    {

        switch ($this->record->status) {
            case OrderStatusEnum::PENDING:
                return 'Confirm';
            case OrderStatusEnum::CONFIRM:
                return 'Delivery';
            case OrderStatusEnum::DELIVERY:
                return 'Received';
            default:
                return 'update-status';
        };
    }
    private function isVisible(): bool
    {
        if ($this->record->status == OrderStatusEnum::PENDING || $this->record->status == OrderStatusEnum::CONFIRM || $this->record->status == OrderStatusEnum::DELIVERY) {
            return true;
        }
        return false;
    }

    protected function getHeaderActions(): array
    {

        return [
            // Actions\EditAction::make(),
            Action::make($this->getLabel())
                ->visible($this->isVisible())
                ->icon('heroicon-m-check')
                ->requiresConfirmation()
                ->action(function (OrderModel $record) {
                    $record->updateOrderStatus();
                    $this->refreshFormData([
                        'status',
                    ]);
                }),
            Action::make('reject')
                // ->disabled()
                ->icon('heroicon-m-x-mark')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (OrderModel $record) {
                    // $record->approve();

                    $this->refreshFormData([
                        'status',
                    ]);
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('order_number'),
                TextEntry::make('user.name')->label('User Name'),
                TextEntry::make('user.phone')->label('User Phone'),
                TextEntry::make('status')->badge(),
            ]);
    }
}
