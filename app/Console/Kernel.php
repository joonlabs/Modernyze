<?php

namespace App\Console;

use Curfle\Essence\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->loadFromDirectory(__DIR__ . "/Commands");
        require base_path('routes/console.php');
    }
}