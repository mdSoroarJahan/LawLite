<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<int,string>
     */
    protected $commands = [
        \App\Console\Commands\DevSeedUsers::class,
        \App\Console\Commands\SeedMessages::class,
    ];
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        //
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
