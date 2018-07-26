<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * 命令行执行命令
     * @var string
     */
    protected $signature = 'test_command {arg}';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = 'my test command';

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
        $arg = $this->argument('arg');
        //这里编写需要执行的动作
        echo $arg;
    }
}