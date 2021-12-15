<?php
/*
* @Created by PhpStorm 2020
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime: 2020/10/20 10:00
* @description:
*/
namespace app\admin\common\Events;

use think\worker\Server;

class Events extends Server{
    protected $socket = 'websocket://127.0.0.1:4567';
    public function websoc()
    {
      $this->worker->count = 1;
      $uid = 0;
      //连接上来的时候
      $this->worker->onConnect = function ($connection){
          global $uid;
          $connection->uid = ++$uid;
      };
      //广播消息
        $this->worker->onMessage = function ($connection,$data){
          foreach ($this->worker->connections as $conn){
              $conn->send("uid: {$connection->uid} said: $data");
          }
        };
        // 当客户端断开时，广播给所有客户端
        $this->worker->onClose = function ($connection) {

            foreach ($this->worker->connections as $conn) {
                $conn->send("user_{$connection->uid} logout");
            }
        };

        $this->worker->runAll();

    }



}