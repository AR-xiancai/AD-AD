<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-07-02 15:25:24
* @description:  common类
*/

namespace app\admin\controller;
use think\Controller;
use think\facade\Request;
use app\Admin\controller\JWTS;
//header('Access-Control-Allow-Origin:*');
// 响应类型
//header('Access-Control-Allow-Methods:*');
//响应头设置
//header('Access-Control-Allow-Headers:x-requested-with,content-type');
//header('Access-Control-Allow-Headers:x-token,x-uid,x-token-check,x-requested-with,content-type,Host');
//解决返回数据乱码
//sheader("Content-type:text/html;charset=utf-8");

class CommonController extends Controller
{
	public function initialize(){

        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods:*');
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,Authorization");
		//不存在user_id就跳到登录页
		//session('user_id',null);
        //判断是否有token值
        $token = Request::header('Authorization');//获取请求头的token值
        //var_dump($token);
        //halt($token);
        if($token == NULL || $token == 'null'){

           echo json_encode([
                'status' => 2001,
                'msg' => 'Token验证不通过!'
            ]);
           exit();
        }else{
            $to = new JWTS();
            $mm = $to->checkToken($token);
            if($mm['status'] == 2001){
                //var_dump($mm);
                echo json_encode($mm);
                exit;
            }
        }


    }
	/*  public function checkToken(){
          //判断token的有效性
          $info = Request::header();
          $token = $info['authorization'];
          var_dump($token);
          if($token === 'null'){
              //halt($token);
              $data = [
                  'status' => 2001,
                  'msg'    => 'Token不存在,拒接访问'
              ];
              return $data;
              exit;
          }else{
              $to = new \app\admin\controller\JWTS();
              $mm = $to->checkToken($token);
              if($mm['status'] !== 200){
                  halt($mm);
//                halt([
//					'code' => 201,
//					'msg'  => '请先登录',
//					'URL'  => '/user/login'
//				]);
              }
          }


      }*/
 		
}