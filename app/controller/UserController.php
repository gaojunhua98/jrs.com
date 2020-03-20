<?php

namespace app\controller;

use think\Session;
use think\Cookie;
use app\common\tool\RequsetTool;
use app\common\logicalentity\User;
use app\controller\ControllerController;

class UserController extends ControllerController
{
    public function login()
    {
    	// $user_name = RequsetTool::postParameters('userName');
		// $user_pwd = RequsetTool::postParameters('password');
		$user_name = input('post.userName');
    	$user_pwd = input('post.password');
    	
    	if(!$user_name || !$user_pwd) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'user_name' => $user_name,
	            		'user_pwd' => $user_pwd,
	            	]
	        ]);
    	}

    	$loginData = [
    			'user_name' => $user_name,
    			'user_pwd' => $user_pwd,
    		];
    		
		if($user = User::doLogin($loginData))
		{
			return  json([
	            'code' => 1,
	            'msg' => '登陆成功',
	            'data' => [
	            		'user_nickname' => $user['user_nickname'],
	            	]
	        ]);
		}
        return  json([
            'code' => -2001,
            'msg' => '登陆失败，用户名或密码错误',
            'data' => ''
        ]);
    }
    
    public function logout()
    {
		//TODO 注销操作
		return  json([
            'code' => 1,
            'msg' => '注销成功',
            'data' => ''
        ]);
        
	}
	
}