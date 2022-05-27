<?php

namespace App\Console\Commands\Product;

use App\Helpers\LoggingHelper;
use App\Jobs\Product\ReUpImageProductJob;
use App\Models\Product;
use Illuminate\Console\Command;

class ReUpImageProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ReUpImageProduct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        ReUpImageProductJob::dispatch();
    }
}
