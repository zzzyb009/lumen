<?php
namespace App\Service\Common;

class SwooleSocketService
{
    private $serv;

    public function __construct()
    {
        // 新建 swoole 服务器
        $this->serv = new \swoole_websocket_server("0.0.0.0", 9502);
        // 设置
        $this->serv->set([
            'daemonize' => false,      // 是否是守护进程
            'max_request' => 10000,    // 最大连接数量
            'dispatch_mode' => 2,
            'debug_mode'=> 1,
            // 心跳检测的设置，自动踢掉掉线的fd
            'heartbeat_check_interval' => 5,
            'heartbeat_idle_time' => 600,
        ]);
        // 注册事件
        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Open', [$this, 'onOpen']);
        $this->serv->on('Message', [$this, 'onMessage']);
        $this->serv->on('Close', [$this, 'onClose']);
        $this->serv->start();
    }

    public function onStart($serv) {
        echo 'Start'.PHP_EOL;
    }

    public function onOpen($serv, $request)
    {
        var_dump($request);
        $this->serv->push($request->fd, "hello, welcome to chatroom\n");
    }

    public function onMessage($ws, $frame)
    {
        $msg = 'from'.$frame->fd.":{$frame->data}\n";

        // 分批次发送
        $start_fd = 0;
        while(true)
        {
            // connection_list函数获取现在连接中的fd
            $connList = $this->serv->connection_list($start_fd, 100);   // 获取从fd之后一百个进行发送
            var_dump($connList);

            if($connList === false || count($connList) === 0)
            {
                echo "finish\n";
                return;
            }

            $start_fd = end($connList);
            
            foreach($connList as $fd)
            {
                $ws->push($fd, $msg);
            }
        }
    }

    public function onClose($serv, $fd)
    {
        echo "client-{$fd} is closed\n";
        $this->serv->close($fd);   // 销毁fd链接信息
    }
}