<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-07-06 15:51:52
* @description:  description
*/

namespace app\admin\controller;
use app\admin\model\Auth;
//use think\Db;
use think\cache\driver\Redis;
class AuthController extends CommonController
{
	public function addAuth(){
	    //取出无限极分类的权限数据
		$authModel = new Auth();
		$oldAuth = $authModel->select()->toArray();
		$auths = $authModel->getSonsAuth($oldAuth);
		return json($auths);

	}
	public function AuthList(){
		$auths = Auth::alias('t1')
					   ->field('t1.*,t2.auth_name as p_name')
					   ->join('sh_auth t2','t1.pid = t2.auth_id','left')
					   ->select();
		$authModel = new Auth();
		$authsData = $authModel->getSonsAuth($auths);
		return json($authsData);
	}
	public function UpdAuth(){
		$auth_id = input('auth_id');
		$authData = db('auth')->find($auth_id);
		dump($authData);
	}
	public function redis(){
		
	}
}