<?php

namespace App\Console;

use App\Obs;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         *
         */
        $schedule->call(function () {
            $current_time = time();
            $last_day_time = time() - (24 * 60 * 60);

            $items = Obs::where('created_at', '>=', $last_day_time)->where('created_at', '<=', $current_time)->get();

            $tmp_lng = '';
            foreach ($items as $item){

                if($tmp_lng == $item->lng)
                    continue;

                $tmp_lng = $item->lng;

                //wifi
            }


        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
