<?php

namespace App\Console\Commands;

use App\Events\NewMessageEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;

class testingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:testing-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // event(new NewMessageEvent(Carbon::now()));
    }
}
