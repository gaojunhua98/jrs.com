<?php

namespace app\controller;

use app\controller\ControllerController;
use app\common\tool\Page;
use app\common\tool\RequestTool;
use app\common\logicalentity\User;

class UserInfoController extends ControllerController
{
	/**
	 * @name 构造函数前执行方法
	 *
	 * @return 
	 */
    public function _initialize()
    {
		//登陆验证
        if(User::isLogin()){
			return  json([
	            'code' => -1010,
	            'msg' => '登陆过期，请先登陆',
	            'data' => []
	        ]);
        }
	}

	/**
	 * 获取用户信息相关
	 *
	 * @return array 用户信息
	 */
    public function getUserInfoById()
    {
		// $userId = RequestTool::postParameters('userId');
		$userId = input('post.userId');
		var_dump($userId);
		$userObj = new User();
		$userInfo = $userObj->doGetUserInfoById($userId);
		var_dump($userInfo);
		die;
		if($userInfo){
			return  json([
	            'code' => 1,
	            'msg' => '获取成功',
	            'data' => [
					'userInfo' => $userInfo
				]
	        ]);
		}
		return  json([
			'code' => 1,
			'msg' => '无数据',
			'data' => []
		]);
	}

	/**
	 * 获取全部用户信息相关
	 *
	 * @return array 用户信息
	 */
    public function getAllUserInfo()
    {
		$pageData = Page::getPageParameters();
		if(!$pageData)
		{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少分页参数',
	            'data' => []
	        ]);
		}
		$userObj = new User();
		$list = $userObj->doGetAllUserInfo($pageData);
		if($list){
			return  json([
	            'code' => 1,
	            'msg' => '获取成功',
	            'data' => [
					'list' => $list
				]
	        ]);
		}
		return  json([
			'code' => 1,
			'msg' => '无数据',
			'data' => []
		]);
	}

	/**
	 * 更新用户信息
	 *
	 * @return array 
	 */
    public function saveUserInfo()
    {
    	$userId = RequestTool::postParameters('userId');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'userId' => $userId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$userObj = new User();
		$res = $userObj->doSaveUserInfo($userId, $updateInfo);
		if($res){
			return  json([
	            'code' => 1,
	            'msg' => '修改成功',
	            'data' => []
	        ]);
		}
		return  json([
			'code' => 1,
			'msg' => '无数据',
			'data' => []
		]);
	}
}