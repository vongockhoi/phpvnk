<?php

namespace App\Console\Commands;

use App\Jobs\MessageJob;
use App\Models\Message;
use Illuminate\Console\Command;
use Log;
use App\Constants\Message as MessageConst;

class PushMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:message';

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
        $messages = Message::where("status", MessageConst::STATUS['UNSENT'])->get();

        if(!empty($messages)){
            MessageJob::dispatch($messages);
        }
    }
}
