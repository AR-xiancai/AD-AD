<?php
/*
* @Created by PhpStorm 2020
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime: 2020/10/20 10:00
* @description:
*/


namespace app\admin\controller;


use think\exception\Handle;
use think\worker\Server;
use Workerman\Worker;
use Workerman\Lib\Timer;//定时类的包
use Workerman\Autoloader;
use Workerman\Worker as W;

class WebSoc extends Server
{
    protected $socket = 'websocket://127.0.0.1:2346';
    protected $option = ["count => 1"];

    public function onWorkerStart($worker)
    {
        define('HEARTBEAT_TIME', 55);//心跳间隔55秒
        // 进程启动后设置一个每10秒运行一次的定时器
        Timer::add(10, function () use ($worker) { //function()use(要调用的外部变量){}闭包函数
            $time_now = time();
            foreach ($worker->connections as $connection) {
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                //上次通讯时间大于心跳时间隔55秒 就代表客户端关闭了连接
                if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                    $connection->close();
                }
            }
        });
    }

    public function onMessage($connection, $data)
    {

        //var_dump($data);

        $user_ip = $connection->getRemoteIp();
        $connection->send("$user_ip"."<\br>".json_encode($data));


    }
    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
            $connection->close('再见!');
    }



}