<?php
/*
* @Created by PhpStorm 2020
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime: 2020/12/9 17:21
* @description:
*/
namespace app\admin\common\Upload;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\facade\Cache;

class Upload{
    private $accessKey ="ZsrYOs54eTuc7ote-ZHb9E_6Oz72uAYc_kTynIyf";
    private $secretKey = "EsWFN59J1Qr2SG8JsE-XK1AJed1jTvR70OaVqd_G";
    //上传一张图片的
    public  function uploadone()
    {
//转移临时文件到指定的目录中去
        foreach ($_FILES as $file) { //遍历$_FILES，$_FILES有几个元素，就意味着上传了几个文件
            //转移当前这个文件，从临时目录中转移到指定的目录中去，并且还要重命名
            $file['name'] = date('Y-m-d-H-i-s-') . $file['name'];
            $newFileName = './images/' . $file['name'];//为当前文件重命名，重命名为当前原始文件的名字
            $re = move_uploaded_file($file['tmp_name'], $newFileName);
          //  return json(['code'=>200,'msg'=>'成功']);
            //拿到文件名 入库 回显图片名称和文件夹的路径给前端 在回显数据

        }
    }
    public function upload(){
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey ="ZsrYOs54eTuc7ote-ZHb9E_6Oz72uAYc_kTynIyf";
        $secretKey = "EsWFN59J1Qr2SG8JsE-XK1AJed1jTvR70OaVqd_G";
        $bucket = "wp2021";//要上传到的七牛云空间名称
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 获取表单上传文件 例如上传了001.jpg
        $file  = $_FILES;
        var_dump($file);
        if(key($file) == 'file'){
            //upload的是文件类型的
            $fileName = date("Y-m-d H:i:s_"). $file['file']['name'];//时间拼接上+上传文件的名
             $filePath = $file['file']['tmp_name'];//上传文件的临时目录
             var_dump($filePath);
        }else{
            //upload的是文件类型的
            $fileName = date("Y-m-d H:i:s_"). $file['image']['name'];//时间拼接上+上传文件的名
            $filePath = $file['image']['tmp_name'];//上传文件的临时目录
        }
        
       
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $fileName, $filePath);
       // echo "\n====> putFile result: \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret['key']);
            //拿到$ret['key']文件名 存进mysql
            Cache::store('redis')->set("name",$ret['key']);

        }

    }

    public function getImg(){
        // 需要填写你的 Access Key 和 Secret Key
        // 构建Auth对象
        $auth = new Auth($this->accessKey, $this->secretKey);
// 私有空间中的外链 http://<domain>/<file_key>
        $name = 'a.jpg';
        $baseUrl = 'http://cdn1.accpwd.cn/'.$name;
// 对链接进行签名
        $signedUrl = $auth->privateDownloadUrl($baseUrl);
        echo $signedUrl;
    }

}