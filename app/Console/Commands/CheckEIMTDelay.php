<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckEIMTDelay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eimt:avgdelay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the average delay for EIMT';

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
        $this->info('The command was successful!');
    }
}
