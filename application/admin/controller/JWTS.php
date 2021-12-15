<?php
/*
* @Created by Sublime Text 3
* @Author: qixianlin
* @Email: qixianlin1017@163.com
* @createTime:   2019-08-23 12:37:27
* @description:  description
*/

namespace app\admin\controller;
//use app\admin\common\Auth\JWTAuth;
use Firebase\JWT\JWT;
use PDO;
use think\facade\Request;
use think\Controller;


class JWTS extends Controller
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
            'exp'   =>  $nowTime+21600,//tocken过期时间  6h => 21600
            'data' => [
             'id'   => $id,
            'uname' => $username
            ]
        );
        $jwt = JWT::encode($token,self::$appkey=config('JWTKEY'),'HS256');//生成token
        return $jwt;

    }
    //token验证
    public function checkToken($token)
    {
            try {
                $msg = [];
                JWT::$leeway = 60;//当前时间减去60，把时间留点余地
                $decoded = JWT::decode($token, self::$appkey = config('JWTKEY'), ['HS256']); //HS256方式，这里要和签发的时候对应
                $authInfo = (array)$decoded;//原来的数据是个object 转换成array
                $userInfo = (array)$authInfo['data'];
                if (!empty($userInfo['uname'])) {
                    $msg = [
                        'status' => 200,
                        'msg' => 'Token验证通过!'
                    ];
                } else {
                    $msg = [
                        'status' => 2001,
                        'msg' => 'Token验证失败'
                    ];
                }
                return $msg;
                //print_r();
            } catch (\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
                //echo $e->getMessage();
                return $msg = [
                    'status' => 2001,
                    'msg' => '签名不正确'
                ];
            } catch (\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
                //echo $e->getMessage();
                return $msg = [
                    'status' => 2001,
                    'msg' => 'Token 还没有生效'
                ];
            } catch (\Firebase\JWT\ExpiredException $e) {  // token过期
                //echo $e->getMessage();
                return $msg = [
                    'status' => 2001,
                    'msg' => 'Token已经过期'
                ];

            } catch (Exception $e) {  //其他错误
                //echo $e;
                return $msg = [
                    'status' => 2001,
                    'msg' => '其他未知错误'
                ];

            }

            //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token

            // return $decoded = JWT::decode($token, self::$appkey=config('JWTKEY'), array('HS256'));
        }

    


}



