<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Rde\Telegram\Connection;
class Telegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Telegram {msg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Telegram description';

    /**
     * Create a new command instance.
     *
     * @return voida
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
        $msg = $this->argument('msg', null);
        $app = \App::make('app');
        $config = $app['config']['database']['telegram'];
        var_dump($config);
        $conn = new Connection($config['token']);
        var_dump($conn);
    }
}
