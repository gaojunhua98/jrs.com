<?php

namespace app\controller;

use app\controller\ControllerController;
use think\Session;
use think\Cookie;
use app\model\UsersModel as User;

class UsersController extends ControllerController
{
    public function login()
    {
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
    		
		if($user = $this::findOne($loginData))
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
    
    public function doLog($data)
    {
	    $user_name = addslashes(trim(stripslashes($data['user_name'])));
        $user_pwd = addslashes(trim(stripslashes($data['user_pwd'])));
        
        $loginData = [
			['user_name', '=', $user_name],
			['user_pwd', '=', $user_pwd],
		];
        if($user = User::getOneUser($loginData))
        {
			//TODO 登陆操作
			session('[start]');
			session('user_nickname', $user['user_nickname']);
			session('user_name', $user['user_name']);
			setcookie("jrsToken", 'gaojunhua98', time()+3600, "/", "127.0.0.1");
            return $user;
        }
		return false;
    }
}