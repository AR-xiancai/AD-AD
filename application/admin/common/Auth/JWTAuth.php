<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-06-27 19:14:16	
* @description:  JWT TOKEN
*/

namespace app\admin\common\Auth;
use \Firebase\JWT\JWT;

class JWTAuth
{
	//
	public static $appkey,$iss,$aud;
	//token签发
	public function createToken($id,$username){
	    $nowTime = time();
			$token = array(
				   'iss'   => self::$iss=config('ISS'),//签发者,可空
				   'aud'   => self::$aud=config('AUD'),//面向的用户,可空
				   'iat'   =>  $nowTime,//签发时间
				   'nbf'   =>  $nowTime+10,//jwt在什么时候生效,(这里5秒后生效)
				   'exp'   =>  $nowTime+600,//tocken过期时间
				   'data'  => [
				       'id' => $id,
                       'username' => $username
                   ]
			);
			// halt(self::$iss);
			$jwt = JWT::encode($token,JWTAuth::$appkey=config('JWTKEY'),'HS256');//生成token
			// return json_encode($jwt);
			return json_encode($jwt);
	}
	//token验证
	public function checkToken($token){
		$decoded = JWT::decode($token, JWTAuth::$appkey=config('JWTKEY'), array('HS256'));
	}






}