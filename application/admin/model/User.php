<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-06-19 11:17:46
* @description:  UserModel
*/

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;//软删除
//use app\admin\common\Auth\JWTAuth;
use app\Admin\controller\JWTS;
//use Firebase\JWT\JWT;
class User extends Model
{
	/**
	 *默认主键
	 * @access protected
	 */
	protected $pk = "user_id";
	/**
	 * 自动写入时间戳
	 * @access protected
	 */
	protected $autoWriteTimestamp = true;
	/**
	 * 软删除
	 */
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	/**
	 * [init 钩子事件]
	 * @param $user user数据集
	 * @return [type] [description]
	 */
	public static function init()
	{
		//入库前事件
		User::event("before_insert",function($user){
//password_hash('password','预定义的常量 详情https://www.php.net/manual/zh/password.constants.php') 加密 password_verify('password',数据库的$hash值)验证密码
			$user['password'] = password_hash($user['password'], PASSWORD_BCRYPT, ['cost' => 12] );
			//$user['password'] = hash('sha256',$user['password'],false);
		});
		//编辑的前事件
//		User::event('before_update',function($user){
//			//密码为空,剔除
//			if($user['password'] == ''){
//				unset($user['password']);
//			}else{
//				//不为空则加密
//				//$user['password'] = hash('sha256',$user['password'],false);
//                $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT, ['cost' => 12] );
//			}
//		});
//
	}

	/**
	 * 检查用户名和密码是否匹配
	 * @param [type] $username 用户名
	 * @param [type] $password 密码
	 * @return [type] true false
	 */
	public function checkUser($username,$password){
		/*$where = [
			'username' => $username,
			'password' => hash('sha256',$password,false),
		];*/
		$userInfo = $this->where("username",'=',$username)->find();
		//halt($userInfo);
        if(password_verify($password,$userInfo['password'])){
            //密码正确返回这条数据的信息
            return $userInfo;
		/*if(password_verify($password,$userInfo['password'])){
			$to = new JWTS();//生成token
			$token = $to->createToken($userInfo['user_id'],$userInfo['username']);
			$data = ['userData' => $userInfo, 'token' => $token ];
			//var_dump($userInfo);
			//设置session
			cache('username',$userInfo['username']);
			cache('user_id',$userInfo['user_id']);

			return json([
				'id'   => $userInfo['user_id'],
				'rid'   => $userInfo['role_id'],
				'username'   => $userInfo['username'],
				'token'  => $token,
				'code'	 => 200,
				'msg'	 => '登录成功!欢迎回来'
			]);*/
			//return $data;
			
		}else{
			return false;
		}
	}


	
}