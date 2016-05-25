<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Rde\Telegram\Connection;

class Test extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Test {msg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test description';

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

        $conn = new Connection($config['token']);
        $conn->sendMessage(array('chat_id' => $config['chat_id'],'text' => $msg));

    }

}
