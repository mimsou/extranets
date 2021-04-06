<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearChunks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chunks:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear chunks';

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
        $storage_path = storage_path() . '/app/chunks/*';
        foreach(glob($storage_path) as $file){
            unlink($file);
        }
        return 1;
    }
}
