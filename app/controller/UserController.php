<?php

namespace app\controller;

use app\common\tool\RequestTool;
use app\common\logicalentity\User;
use app\controller\ControllerController;

/**
 * @name 用户相关接口
 */
class UserController extends ControllerController
{
	/**
	 * @name 登陆接口
	 */
    public function login()
    {
    	$userName = RequestTool::postParameters('userName');
		$password = RequestTool::postParameters('password');
    	
    	if(!$userName || !$password) 
    	{
	    	return  json_encode([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'userName' => $userName,
	            		'password' => $password,
	            	]
	        ]);
    	}

    	$loginData = [
    			'userName' => $userName,
    			'password' => $password,
    		];
    		
		if($user = User::doLogin($loginData))
		{
			return  json_encode([
	            'code' => 1,
	            'msg' => '登陆成功',
	            'data' => [
	            		'user_nickname' => $user['user_nickname'],
	            	]
	        ]);
		}
        return  json_encode([
            'code' => -2001,
            'msg' => '登陆失败，用户名或密码错误',
            'data' => ''
        ]);
    }
    
    public function logout()
    {
    	$user_name = RequestTool::postParameters('userName');
		if(User::doLogout($user_name))
		{
			return  json_encode([
				'code' => 1,
				'msg' => '注销成功',
				'data' => ''
			]);
		}
		return  json_encode([
            'code' => 1,
            'msg' => '注销失败',
            'data' => ''
        ]);
        
	}
	
}