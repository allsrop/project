<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Telegram extends Command
{
    public $me;
    private $url;
    private $timeout = 0;
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

        $this->runn($config['token']);
        $this->sendMessage(array('chat_id' => $config['chat_id'],'text' => $msg));

    }

    public function runn($token, $target = 'https://api.telegram.org/bot')
    {
        $this->url = $target.$token;

        $this->me = $this->__call('getMe', array());

    }

    public function getMe()
    {
        return $this->me;
    }

    public function timeout($t)
    {
        $this->timeout = (int) $t;

        return $this;
    }

    protected function resolveData($str)
    {
        $res = json_decode($str);

        if ($res && $res->{'ok'}) return $res->{'result'};

        return false;
    }

    protected function resolveUrl($api, $params)
    {
        ! empty($params) and $payload = is_string($params) ? $params : http_build_query($params);

        return "{$this->url}/{$api}".(isset($payload) ? "?{$payload}" : '');
    }

    public function __call($method, $params)
    {
        $url = $this->resolveUrl($method, array_shift($params));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        $ret = curl_exec($ch);

        if ($err = curl_error($ch)) {
            throw new \RuntimeException($err);
        }

        return $this->resolveData($ret);
    }
}
