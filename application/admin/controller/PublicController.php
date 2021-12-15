<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-08-19 19:52:09
* @description:  description
*/

namespace app\admin\controller;

use app\admin\model\User;
use think\captcha\Captcha;
use think\Db;
use think\facade\Cache;
use think\Request;
use think\Controller;
header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:*');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,Authorization");
class PublicController extends Controller
{       
		/**
	 * [login description]
	 * @access public
	 * @return [json]  [userData & token & code & msg]
	 */

		protected $config = [
            'fontSize' => 16,
            'imageH'   =>  40,
            'imageW'   =>  125,
            'length'   =>  4,
            'useNoise' =>  true,
            'useCurve' => true,
            'seKey'    => 'api.buzhi.com',
            'codeSet' => '0123456789',
            'fontttf' => '7.ttf'
        ];
	public function login(){
		if(request()->isPost()){
			$postData = input('post.');
			$userModel = new User();
			$code = $postData['captcha'];
           // var_dump($captcha);
            //判断验证码和redis的验证码是否一致
            $cap = new Captcha();
            $capt = $cap->checkCode($code);
            /*  if( !$cap->check($code)){
                return json(['msg' => "$code".'验证码不正确!','code'=>201]);
            }  */
              if(!$capt){
               return json(['msg' => '验证码不正确!','code'=>201]);
            }
           //验证器验证
            $result = $this->validate($postData,'User.login',[],true);
            //var_dump($result);
            if($result !== true){
                return json(['msg' => implode(',',$result),'status'=>201]);
            }
            $status = $userModel->checkUser($postData['username'],$postData['password']);
            if($status){
                $to = new JWTS();//生成token
                $token = $to->createToken($status['user_id'],$status['username']);
                $data = ['userData' => $status, 'token' => $token ];
                //var_dump($userInfo);
                //设置session
                cache('username',$status['username']);
                cache('user_id',$status['user_id']);

                return json([
                    'id'   => $status['user_id'],
                    'rid'   => $status['role_id'],
                    'username'   => $status['username'],
                    'token'  => $token,
                    'code'	 => 200,
                    'msg'	 => '登录成功!欢迎回来'
                ]);
               // return $status;

            }else{
                //echo "登录失败,请稍后再试";
                return json([
                    'data' => [],
                    'code' => 201,
                    'msg'  => '用户名或密码错误'
                ]);
            }

		}
	}
    public function capt(){


        $cap = new Captcha($this->config);
        return $cap->entry();

    }
	public function logout(){
		cache('username',null);
		cache('user_id',null);
		return json([
			'status' => 200,
			'msg'	 => '退出成功',
			'URL' 	 => '/public/login'
		]);
	}
}