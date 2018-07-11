<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TrelloController;

class pushPlipToTrello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plip:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iterate over petitions and send them to trelloboard in cards format';

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
        $trelloController = new TrelloController();
        $trelloController->pushPlipToTrello();
    }
}
