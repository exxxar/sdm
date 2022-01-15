<?php

namespace App\Console\Commands;

use App\Classes\DeviceParameterHistoryLogger;
use Illuminate\Console\Command;

class AutoLoggerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:logger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run immediately logger to upload data from devices for the last hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DeviceParameterHistoryLogger $deviceLogger)
    {
        $deviceLogger->logHandler();
        return 0;
    }
}