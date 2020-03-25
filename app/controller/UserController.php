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
	    	return  json([
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
			return  json([
	            'code' => 1,
	            'msg' => '登陆成功',
	            'data' => [
						'token' => $user['user_id'],
						'exp_time' => time()+24*3600,
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
    	$user_name = RequestTool::postParameters('userName');
		if(User::doLogout($user_name))
		{
			return  json([
				'code' => 1,
				'msg' => '注销成功',
				'data' => ''
			]);
		}
		return  json([
            'code' => 1,
            'msg' => '注销失败',
            'data' => ''
        ]);
        
	}

	public function getUserName()
    {
		$user_id = RequestTool::getParameters('token');
		$user = User::doGetUserName($user_id);
		if($user)
		{
			return  json([
				'code' => 1,
				'msg' => '获取成功',
				'data' => [
					'id' => $user['user_id'],
					'username' => $user['user_name']
				]
			]);
		}
		return  json([
            'code' => 1,
            'msg' => '获取失败',
            'data' => ''
        ]);
        
	}

	public function addUser()
	{
		$addInfo = RequestTool::postParameters('addInfo');
		$userObj = new User();
		$res = $userObj->doAddUser($addInfo);
		if($res)
		{
			return  json([
				'code' => 1,
				'msg' => '添加成功',
				'data' => []
			]);
		}
		return  json([
            'code' => 1,
            'msg' => '添加失败',
            'data' => [
				'addInfo' => $addInfo,
			]
        ]);
	}
	
}