<?php
namespace App\Service\Common;

class SwooleService
{
    private $serv;
    private $artisanPath;

    public function __construct()
    {
        // 确定 artisan 的位置
        $filePath = __DIR__;
        $this->artisanPath = $filePath . '/../../../artisan';
        // 新建 swoole 服务器
        $this->serv = new \swoole_server('0.0.0.0', 9501);
        // 设置
        $this->serv->set([
            'reactor_num' => 2, //reactor thread num
            'worker_num' => 2,  //worker process num
            'backlog' => 128,   //listen backlog
            'max_request' => 50,
            'dispatch_mode' => 1,
            'task_worker_num' => 1,
        ]);
        // 注册事件
        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Close', [$this, 'onClose']);
        $this->serv->on('Task', [$this, 'onTask']); 
        $this->serv->on('Finish', [$this, 'onFinish']);
        $this->serv->start();
    }

    public function onStart($serv) {
        echo 'Start'.PHP_EOL;
    }

    public function onConnect($serv, $fd, $form_id) {
        echo 'client ' . $fd . ' connect'.PHP_EOL;
    }

    public function onClose($serv, $fd, $form_id) {
        echo 'client ' . $fd . ' close connection'.PHP_EOL;
    }

    public function onReceive($serv, $fd, $form_id, $string) {
        echo 'get message from ' . $fd . ':' . $string . PHP_EOL;

        if (strpos($string, ':') !== false) {
            $data = explode(':', $string);
            $opt = ['command' => $data[0], 'arg' => $data[1]];
        } else {
            $opt = ['command' => $string];
        }
        // 获取所有可用指令
        $commands = system("php {$this->artisanPath} list --format=json");
        $commands = json_decode($commands);
        $canUseCommand = [];
        foreach ($commands->commands as $command) {
            $canUseCommand[] = $command->name;
        }
        $isInArray = in_array($opt['command'], $canUseCommand);
        // 指令不存在结束执行，返回错误
        if ($isInArray === false) $this->serv->send($fd, 'run failed 2');

        $options = ['params' => $opt, 'fd' => $fd];
        $this->serv->task(json_encode($options));
    }

    public function onTask($serv, $task_id, $form_id, $data) {
        echo 'task: ' . $task_id . ', from: ' . $form_id .', data: '. $data; 
        $info = json_decode($data, true);

        try {
            if (isset($info['params']['arg']) && !empty($info['params']['arg'])) {
                $ret = system("php {$this->artisanPath} {$info['params']['command']} {$info['params']['arg']}", $retCode);
            } else {
                $ret = system("php {$this->artisanPath} {$info['params']['command']}", $retCode);
            }
            if ($retCode == 0) {
                $this->serv->send($info['fd'], $ret);
            } else {
                $this->serv->send($info['fd'], 'run failed 1');
            }
        } catch (Exception $e) {

            $this->serv->send($info['fd'], 'run failed 0');
        }
    }

    public function onFinish($srev, $task_id, $data) {
        echo 'task ' . $task_id . ' finish'.PHP_EOL;
        echo 'Rresult :' . $data.PHP_EOL; 
    }
}