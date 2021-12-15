<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
	//规则
	protected $rule = [
		'username'		=>		'require|unique:user|min:4',
		'mobile'		=>      'mobile',
		'password'		=>		'require',
		'repassword'	=>		'require|confirm:password',
		'captcha'		=>		'require|captcha',
	];

	//提示信息
	protected $message = [
		'username.require'	=>	'请填写用户名',
		'username.unique'	=>	'用户名已存在',
		'username.min'		=>	'用户名最低长度4位',
		'mobile.mobile'		=>  '请填写正确的手机号码',
		'password.require'	=>	'请填写密码',
		'repassword,require'=>	'请再次填写密码',
		'repassword.confirm'=>	'密码不一致',
		'captcha.require'	=>	'请填写验证码',
		'captcha.captcha'	=>	'验证码错误',

	];

	//场景
	protected $scene = [
		'add' => ['username','password','repassword','mobile'],
		'upd' => ['username','password','repassword'],
		'login'=> ['username'=>'require','password'],//,'captcha'

	];
}