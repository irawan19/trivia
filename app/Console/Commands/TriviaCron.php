<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class TriviaCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trivia:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto update status game and sessions';

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
     * @return mixed
     */
    public function handle()
    {
        
        $this->info("It's worked.");
    }
}
