<?php

namespace App\Console\Commands\Weekly\RunOnWed;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearLogActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-log-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job for 0H';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('log_activities')->delete();
    }
}
