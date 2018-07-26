<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Common\SwooleService as Swoole;

class SwooleServer extends Command
{
    /**
     * 命令行执行命令
     * @var string
     */
    protected $signature = 'start_swoole_task_server';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = 'run swoole server';

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