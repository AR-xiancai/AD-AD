<?php
/*
* @Created by PhpStorm 2020
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime: 2021/1/19 19:27
* @description:
*/
namespace app\admin\common\Events;

use Workerman\Worker;

class Websoc{
    public function Websoc(){
        $woker = new Worker('127.0.0.1:4567');
        $woker->onMessage('nihao');
    }

}