<?php

namespace App\Console\Commands;

use App\Imports\OutputHistoryImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class UploadHistorical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:local';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload history data from local dump (excel)';

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
    public function handle()
    {
        ini_set('max_execution_time', 20000);
        ini_set('memory_limit', '1256M');
        Excel::import(new OutputHistoryImport, storage_path('app/public/templates/').'output.xlsx');
        ini_set('max_execution_time', 20);
        return 0;
    }
}
