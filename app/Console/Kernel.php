<?php

namespace App\Console;

use App\Ahkas\Domain\Product\ProductModel;
use App\Console\Commands\FlashSaleCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('scout:flush', [ProductModel::class])->everyMinute();
        // $schedule->command('scout:import', [ProductModel::class])->everyMinute();
        // $schedule->command(FlashSaleCommand::class)->everySecond();

        // $schedule->command('app:testing-command')->everyFiveSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
