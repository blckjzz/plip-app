<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PetitionController;

class sync_petition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:plip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically sync plips from typeform to database';

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
        $petitionController = new PetitionController;
        $petitionController->syncPlips();
        $this->info('sync:plip Run successfully!');
    }
}
