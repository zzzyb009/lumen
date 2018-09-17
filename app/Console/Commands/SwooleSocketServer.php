<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Common\SwooleSocketService as Swoole;

class SwooleSocketServer extends Command
{
    /**
     * 命令行执行命令
     * @var string
     */
    protected $signature = 'start_swoole_socket_server';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = 'run swoole socket server';

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
        new Swoole();
    }
}