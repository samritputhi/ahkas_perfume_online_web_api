<?php

namespace App\Ahkas\Admin\Resources\ReceiveOrderResource\Pages;

use App\Ahkas\Admin\Resources\ReceiveOrderResource;
use App\Ahkas\Domain\Order\enum\OrderStatusEnum;
use App\Ahkas\Domain\Order\OrderModel;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListReceiveOrders extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ReceiveOrderResource::class;

    protected function getHeaderWidgets(): array
    {
        return ReceiveOrderResource::getWidgets();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All Order')
                ->icon('heroicon-m-user-group'),
            $this->myTab(OrderStatusEnum::PENDING),
            $this->myTab(OrderStatusEnum::CONFIRM),
            $this->myTab(OrderStatusEnum::DELIVERY),
            $this->myTab(OrderStatusEnum::RECEIVE),
            $this->myTab(OrderStatusEnum::CANCEL),
            $this->myTab(OrderStatusEnum::REJECT),

        ];
    }

    private function myTab(OrderStatusEnum $status)
    {
        return Tab::make($status->getLabel())
            ->icon($status->getIcon())
            ->badgeColor($status->getColor())
            ->query(fn ($query) => $query->where('status', $status))
            ->badge(OrderModel::query()->where('status', $status)->count());
    }

    public ?string $activeTab = 'All Order';
}
