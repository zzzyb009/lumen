<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleClientWorker extends Command
{
    /**
     * 命令行执行命令
     * @var string
     */
    protected $signature = 'swoole_client_worker {order}';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = 'run swoole client worker commands';

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
        $order = $this->argument('order');

        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('0.0.0.0', 9501, -1)) exit("connect failed. Error: {$client->errCode}\n");
        $client->send($order);
        
        echo $client->recv();
        $client->close();
    }
}