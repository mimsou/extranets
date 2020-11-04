<?php

namespace App\Console\Commands;

use App\Imports\ContactImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportContact extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:contact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get contact xls the import it';

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
        Excel::import(new ContactImport, storage_path().'/contacts.xls');
        return 0;
    }
}
