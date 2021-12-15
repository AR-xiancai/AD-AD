<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-06-18 08:39:54
* @description:  user-CURD
*/

namespace app\admin\controller;

//use think\Controller;
use app\admin\model\User;
use think\Db;
use think\facade\Cache;
use think\facade\Request;
//use think\Request;

class UserController extends CommonController
{
	/**
	 * user list
	 * @access public
	 * @return [json] [userDataList]
	 */
	public function index(){
        $userModel = new User();
        $pagesize = input('pagesize');//前端传过来的条数
        $pagenum = input('pagenum');//前端传过来的页码
        $userData = [];
		$userData['data'] = $userModel->order(['user_id'=>'desc'])->page($pagesize,$pagenum)->select();
        $userData['total'] = $userModel->count();//获取数据的总条数
        //echo json_encode($userData); //这个输出的话 会使得element的表格的tableData为undefined
		exit(json_encode($userData));

	}
	/**
	 * user add
	 * @access public
	 * @return [json] [code msg]
	 */
	public function add(){
		if(request()->isPost()){
			$postData = input('post.');
			$result = $this->validate($postData,'User.add',[],true);
			if($result !== true){
				return json(['msg' => implode(',',$result),'status'=>201]);
			}
			$addModel = new User();			
			if($addModel->allowField(true)->save($postData)){
				$data = ['status' => 200,'msg'	=> "添加新用户成功!"];
			}else{
				$data = ['status' => 201,'msg'	=> '添加失败!请联系管理员'];
			}
		}
		return json($data);
	}
	/**
	 * [user delete]
	 * @access public
	 * @return [json]  [code msg]
	 */
	public function del(){
		$user_id = input('user_id');
		
		if(User::destroy($user_id)){
			$data = ['code' => 200,'msg'  => '删除成功!'];
		}else{
			$data = ['code' => 201,'msg'  => '删除失败!请稍后再试或联系管理员'];
		}
		return json($data);
	}
		/**
		 * [upd user]
		 * @return [json] [status msg]
		 */
		public function upd(){
		$userModel = new User();
		//判断是否是post请求
		if(request()->isPost()) {
            //接收post参数
            $postData = input('post.');
            $user = new User;
           $data =  $user->save([
                'username'  => $postData['username'],
                'mobile' => $postData['mobile'],
                'role_id'=> $postData['role_id'],
            ],['user_id' => $postData['user_id']]);
          if($data){
              return json( ['msg'=> '更新成功!','code' => ' 200'] );

          }else{
              return json( ['msg'=> '更新失败!问问管理员看看?','code' => '201' ]);
          }
            //post数组中只有name和email字段会写入
            //$data = Request::only(['username', 'mobile', 'role_id']);
            //$userModel->save($data, ['user_id' => $postData['user_id']]);
        }
//			exit;
//			$req = DB::table('sh_user')->where('user_id',$postData['user_id'])->find();
//			//判断userid 有没有在
//			if($req == null){
//				return json([
//					'msg' => '不存在该用户',
//					'status' => 201
//				]);
//			}
//			//验证器验证
//			//密码和确认密码不空就改密码
//			if($postData['password'] !='' || $postData['repassword'] !=''){
//				//用户改了密码,验证一下
//				$result = $this->validate($postData,'user.upd',[],true);
//				if($result!==true){
//					return json(['msg' => $result,'status'=>202]);
//
//				}
//			}
//			if($userModel->allowField(true)->isUpdate(true)->save($postData)){
//					$data = ['status' => 200,'msg'	=> '更新成功'];
//				}else{
//					$data = ['status' => 201,'msg'	=> "更新失败"];
//				}
//				return json($data);
//		}
	} 

        //用户搜索
    public function search(){
//				$info = Request::header();
//				$token = $info['authorization'];
//				$to = new JWTS();
//                $mm = $to->checkToken($token);
//                var_dump($mm);
		        $query = input('query');
				//exit(json_encode($query));
		        $userMode = new User();
               $data = $userMode
                            ->where('user_id','=',$query)
							->whereOr('username','like',"$query".'%')
                            ->select()
							->toArray(); 
	
				if(!empty($data)){
					$datas = ['data'=>$data,'status'=>'成功','msg'=>200];
				}else{
					$datas = ['data'=>"该用户不存在!",'msg'=>'失败','status'=>201];
				}
				return json($datas);


    }
    public function user_info(){
		    $user_id = input('user_id');
		    $userData = User::find($user_id);
		    if(is_null($userData)){
		        return json(['code'=>201 ,'msg'=>'获取用户信息失败!']);
            }
		    $userData['code'] = 200;
		    $userData['msg'] = 'cg';
		   return json($userData);
    }
    public function upload(){


    }

}
