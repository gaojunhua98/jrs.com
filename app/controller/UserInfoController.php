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
		$userInfoId = RequestTool::getParameters('user_info_id');
		$userObj = new User();
		$userInfo = $userObj->doGetUserInfoById($userInfoId);
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
		$query = json_decode(RequestTool::getParameters('query'));
		if(!$pageData)
		{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少分页参数',
	            'data' => []
	        ]);
		}
		$userObj = new User();
		$where = [];
		if(!empty($query)) {
			if(is_object($query)) {
				$query = (array)$query;
			}
			foreach($query as $key => $value)
			{
				$where[] = [$key, 'LIKE', '%' . $value . '%'];
			}
		}

		$list = $userObj->doGetAllUserInfo($where,$pageData);
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
    	$userInfoId = RequestTool::postParameters('user_info_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'user_info_id' => $userInfoId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$userObj = new User();
		$res = $userObj->doSaveUserInfo($userInfoId, $updateInfo);
		if($res){
			return  json([
	            'code' => 1,
	            'msg' => '修改成功',
	            'data' => []
	        ]);
		}
		return  json([
			'code' => -2001,
			'msg' => '修改失败',
			'data' => []
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
            'code' => -2001,
            'msg' => '添加失败',
            'data' => [
				'addInfo' => $addInfo,
			]
        ]);
	}
	
}