<?php
namespace app\index\controller;


class  IndexController
{
    public function index()
    {        
        
       // exit;
         /*$nb = 99.901;
                echo floatval($nb);
                echo '</br>';
                echo rtrim(rtrim($nb, '0'), '.');
                exit();*/
            /*
             * curl 发起post请求 $url
             * @param string $url post请求的url地址
             * @param array $data post请求的数据
             * @return json $output 接口返回的json数据
             * */
            $url = 'http://127.0.0.1:8000/blog/login/';
            $data = ['uname'=>'admin','pwd'=>123456];
            //$data  = json_encode($data); //加了下面的 导致请求django的接口错误
            //$headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
            $headerArray = [];#设置请求头信息
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            //return json_decode($output,true);
            return $output;



        // 获取表单上传文件 例如上传了001.jpg
//        $file = request()->file('image');
//        // 移动到框架应用根目录/uploads/ 目录下
//        $info = $file->move('../images');
//        if ($info) {
//            // 成功上传后 获取上传信息
//            // 输出 jpg
//            echo $info->getExtension();
//            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getSaveName();
//            // 输出 42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getFilename();
//        } else {
//            // 上传失败获取错误信息
//            echo $file->getError();
//        }
//    }
        //echo "ok";

    }
}

