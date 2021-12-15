<?php
/*
* @Created by PhpStorm 2020
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime: 2021/3/10 19:00
* @description:
*/

namespace app\admin\common\Events;
use think\queue\Job;

class jobs
{
    public function fire(Job $job, $data){

        //....这里执行具体的任务
        cache('starttime',time());
        if ($job->attempts() == 2) {
            //通过这个方法可以检查这个任务已经重试了几次了
            //如果任务执行成功后 记得删除任务，不然这个任务会重复执行，直到达到最大重试次数后失败后，执行failed方法
            cache('endtime',time());
            $job->delete();
        }
        // 也可以重新发布这个任务
        //$job->release($delay); //$delay为延迟时间

    }
    /**
     * 任务达到最次数失败
     * @param $data
     */
    public function failed($data){
        // ...任务达到最大重试次数后，失败了
        cache('failtime',time());
    }

}