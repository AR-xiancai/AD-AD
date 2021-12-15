<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('hello/:name', 'index/hello');

// return [

// ];
Route::get('/Job','index/JobTest/testJob');
Route::get('/index','index/index/index');
Route::any('/upload','\app\admin\common\Upload\Upload@uploadone')->allowCrossDomain();
Route::any('/up','\app\admin\common\Upload\Upload@upload')->allowCrossDomain();
Route::any('/getimg','\app\admin\common\Upload\Upload@getImg')->allowCrossDomain();
Route::any('/soc','\app\admin\common\Events\Events@websoc')->allowCrossDomain();
//Route::get('/','Login');
//Route::get('/','admin/index/index');
Route::get('/','index/index/index');
    Route::get('/top','admin/index/top');
//api.demo.com ===> www.demo.com/IndexController.php/api
//Route::domain('api','api');//域名路由
//Route::get('/Login','/');
//Route::alias('user','admin/user/index');
Route::group('admin',function(){
	Route::alias('user','admin/user',[
		'method' => [
			'index' => 'GET',
			'add'	=> 'POST',
			//'login' => 'POST',
			'del'	=> 'ANY',
			'upd'	=> 'POST',
			//'logout' =>
            'search' => 'ANY',
            'user_info' => 'GET',
            'upload'    => 'POST',
		],
	])->allowCrossDomain();
	Route::alias('public','admin/public',[
		'method' => [
		    'capt' => 'GET',
			'login' => 'POST',
			'logout' => 'GET'
		],
	]);
	Route::alias('auth','admin/auth',[
		'method' => [
			'addAuth' => 'ANY',
			'AuthList' => 'GET',
			'UpdAuth/:auth_id' => 'GET'
		]
	]);
	Route::alias('server','admin/server',[
	    'method' => [
	        'index' => 'ANY',
        ]
    ]);


});