<?php

namespace App\Ahkas\Admin\Resources\ReceiveOrderResource\Widgets;

use App\Ahkas\Admin\Resources\ReceiveOrderResource\Pages\ListReceiveOrders;
use App\Ahkas\Domain\Order\OrderModel;
use Filament\Support\Colors\Color;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;


class OrderStat extends BaseWidget
{
    use InteractsWithPageTable;


    protected function getTablePage(): string
    {
        return ListReceiveOrders::class;
    }
    protected function getStats(): array
    {


        $orderData = Trend::model(OrderModel::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Orders', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                )->icon('heroicon-o-rectangle-stack')
                ->color(Color::Green),
            Stat::make('Open orders', $this->getPageTableQuery()
                ->whereIn('status', ['pending', 'confirm'])
                ->count(),)
                ->icon('heroicon-o-rectangle-stack')
                ->color(Color::Blue)
                ->description('Toal of Pending and Confirm status'),
            Stat::make('Average price', number_format($this->getPageTableQuery()
                ->avg('total_item_price'), 2))
                ->icon('heroicon-o-rectangle-stack'),
        ];
    }
}
