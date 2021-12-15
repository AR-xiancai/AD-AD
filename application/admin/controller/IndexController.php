<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-06-14 10:29:16
* @description:  后台首页
*/
namespace app\admin\controller;

//use think\Controller;
use think\cache\driver\Redis;
use think\facade\Cache;
use think\Db;
use think\App;
use think\captcha\Captcha;
use ZipArchive;

class IndexController extends CommonController
{
	public function index(){
	    //phpinfo();
		//$zip = new ZipArchive;
		// $filepath   = "D:\wwwroot\WWW\gou.jpg";
		// $entryname = "D:\\wwwroot\\WWW\\11.zip";
		// //$zip_file = 'invoices.zip'; // 要下载的压缩包的名称
		// // 初始化 PHP 类
		// 	$zip = new ZipArchive;
		// 	//var_dump($zip);
		// 	if($zip->open($entryname) === TRUE){
		// 		$zip->addFile($filepath);
		// 		$zip->close();
		// 		echo "200";
		// 	}else{
		// 		echo "202";
		// 	}
	    // exit;
	    $redis = new Redis();
	    $redis->handler()->
        // date('Ymd');
	   //var_dump(range('a','Z'));
	    //exit;
			
		 $cap = new Captcha();
		 $cap->length = 4;
		 $cap->imageH = 40;
		 $cap->imageW = 130;
		 $cap->fontSize =18;
		 $cap->useCurve = false;
         $cap->useNoise = false;
		 //$cap->useZh = true;
		 $cap->useImgBg = false;
		return $cap->entry();
		//$arr = [1,2,34,5,6,7,67,6];
		//exit(json_encode($arr));
		//exit(json_encode($cap->entry()));
		//return $this->fetch('');
		//$pass = password_hash("Lqx0113..!", PASSWORD_BCRYPT, ['cost' => 12] );
        //echo App::VERSION;
      /*  $data = Db::table('sh_user')->where('username','linqixian')->find();
		if($data){
		    print_r($data);
		    dump("yes");
        }else{
		    dump("no");
        }*/


	}

	public function top(){
		
 echo '111';

	}	
		
}