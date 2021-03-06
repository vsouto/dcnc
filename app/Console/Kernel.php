<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ImportCorrespondentes::class,
        Commands\ImportAdvogados::class,
        Commands\ImportUsers::class,
        Commands\CheckCriticas::class,
        Commands\CheckAltas::class,
        Commands\CheckAtrasos::class,
        Commands\Checkin::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:criticas')
            ->everyMinute();

        $schedule->command('check:altas')
            ->everyFiveMinutes();

        $schedule->command('check:atrasos')
            ->everyThirtyMinutes();

        $schedule->command('check:in')
            ->everyThirtyMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
