<?php
/*
* @Created by PhpStorm 2020
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime: 2021/3/11 17:19
* @description:
*/

namespace app\index\controller;
use think\Db;
use think\Queue;
use think\Queue\JOb;

class JobTestController
{
    public function index(){
        echo  "nihao1";
    }

    public function  testJob(){
        // 1.当前任务将由哪个类来负责处理。
        //   当轮到该任务时，系统将生成一个该类的实例，并调用其 fire 方法
        $jobHandlerClassName  = 'app\index\job\Hello';

        // 2.当前任务归属的队列名称，如果为新队列，会自动创建
        $jobQueueName     = "Job1";

        // 3.当前任务所需的业务数据 . 不能为 resource 类型，其他类型最终将转化为json形式的字符串
        // ( jobData 为对象时，需要在先在此处手动序列化，否则只存储其public属性的键值对)
        $jobData          = [ 'type' =>'1', 'id' => uniqid() , 'data' => '你好!我是老狗!' ] ;

        // 4.将该任务推送到消息队列，等待对应的消费者去执行

            $isPushed = Queue::push( Job::class , $jobData , $jobQueueName );

        //$isPushed = Queue::later(10,$jobHandlerClassName,$jobData,$jobQueueName); //把任务分配到队列中，延迟10s后执行

        // database 驱动时，返回值为 1|false  ;   redis 驱动时，返回值为 随机字符串|false
        if( $isPushed !== false ){
          //  Db::name('test')->insert($jobData);
            echo date('Y-m-d H:i:s') . "queue的MQ队列发出成功!"."<br>";
        }else{
            echo 'something went wrong.';
        }
    }



}