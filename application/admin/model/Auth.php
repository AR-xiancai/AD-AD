<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-07-10 20:19:54
* @description:  Auth
*/

namespace app\admin\model;
 use think\Model;

class Auth extends Model
{
	protected $pk = 'auth_id';
	 protected $autoWriteTimestamp = true;

	public function getSonsAuth($data,$pid = 0,$level = 1){
		static $result = [];//静态数组,递归初始化一次
		foreach( $data as $v ){
			if($v['pid'] == $pid){
				$v['level'] = $level;
				//储存到$result中
				$result[] = $v;
				//递归调用
				$this->getSonsAuth($data,$v['auth_id'],$level + 1);
			}
		}

		return $result;

	}
}