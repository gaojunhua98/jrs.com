<?php

namespace app\controller;

use app\common\tool\Page;
use app\common\tool\RequestTool;
use app\common\logicalentity\jrs\User;
use app\common\logicalentity\jrs\UserWages;
use app\common\logicalentity\jrs\Activity;
use app\common\logicalentity\jrs\Department;
use app\common\logicalentity\jrs\UserWorkAttendance;
use app\common\logicalentity\jrs\SpecialUserWorkAttendance;
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
	
	/**
	 * @name 注销接口
	 */
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

	//TODO 活动列表获取
	public function getActivityList()
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
		$activityObj = new Activity();
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
		$where[] = ['is_del', '=', 0];

		$list = $activityObj->doGetActivityList($where,$pageData);
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

	//TODO 活动创建
	public function createActivity()
	{
		$addInfo = RequestTool::postParameters('addInfo');
		$activityObj = new Activity();
		$res = $activityObj->doCreateActivity($addInfo);
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

	//TODO 活动修改
    public function updateActivity()
    {
    	$activityId = RequestTool::postParameters('activity_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'activity_id' => $activityId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$activityObj = new Activity();
		$res = $activityObj->doUpdateActivity($activityId, $updateInfo);
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

	//TODO 部门列表获取
	public function getDepartmentList()
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
		$departmentObj = new Department();
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
		$where[] = ['is_del', '=', 0];

		$list = $departmentObj->doGetDepartmentList($where,$pageData);
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

	//TODO 部门创建
	public function createDepartment()
	{
		$addInfo = RequestTool::postParameters('addInfo');
		$departmentObj = new Department();
		$res = $departmentObj->doCreateDepartment($addInfo);
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

	//TODO 部门修改
	public function updateDepartment()
	{
		$departmentId = RequestTool::postParameters('department_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'department_id' => $departmentId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$departmentObj = new Department();
		$res = $departmentObj->doUpdateDepartment($departmentId, $updateInfo);
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

	//TODO 工资列表获取
	public function getUserWagesList()
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
		$userWagesObj = new UserWages();
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
		$where[] = ['is_del', '=', 0];

		$list = $userWagesObj->doGetUserWagesList($where,$pageData);
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

	//TODO 工资创建
	public function createUserWages()
	{
		$addInfo = RequestTool::postParameters('addInfo');
		$userWagesObj = new UserWages();
		$res = $userWagesObj->doCreateUserWages($addInfo);
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

	//TODO 工资修改
	public function updateUserWages()
	{
		$userWagesId = RequestTool::postParameters('user_wages_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'user_wages_id' => $userWagesId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$userWagesObj = new UserWages();
		$res = $userWagesObj->doUpdateUserWages($userWagesId, $updateInfo);
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

	//TODO 考勤列表获取
	public function getUserWorkAttendanceList()
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
		$userWorkAttendanceObj = new UserWorkAttendance();
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
		$where[] = ['is_del', '=', 0];

		$list = $userWorkAttendanceObj->doGetUserWorkAttendanceList($where,$pageData);
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

	//TODO 考勤创建
	public function createUserWorkAttendance()
	{
		$addInfo = RequestTool::postParameters('addInfo');
		$userWorkAttendanceObj = new UserWorkAttendance();
		$res = $userWorkAttendanceObj->doCreateUserWorkAttendance($addInfo);
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

	//TODO 考勤修改
	public function updateUserWorkAttendance()
	{
		$userWorkAttendanceId = RequestTool::postParameters('user_work_attendance_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'user_work_attendance_id' => $userWorkAttendanceId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$userWorkAttendanceObj = new UserWorkAttendance();
		$res = $userWorkAttendanceObj->doUpdateUserWorkAttendance($userWorkAttendanceId, $updateInfo);
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

	//TODO 特殊考勤列表获取
	public function getSpecialUserWorkAttendanceList()
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
		$specialUserWorkAttendanceObj = new SpecialUserWorkAttendance();
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
		$where[] = ['is_del', '=', 0];

		$list = $specialUserWorkAttendanceObj->doGetSpecialUserWorkAttendanceList($where,$pageData);
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

	//TODO 特殊考勤创建
	public function createSpecialUserWorkAttendance()
	{
		$addInfo = RequestTool::postParameters('addInfo');
		$specialUserWorkAttendanceObj = new SpecialUserWorkAttendance();
		$res = $specialUserWorkAttendanceObj->doCreateSpecialUserWorkAttendance($addInfo);
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

	//TODO 特殊考勤修改
	public function updateSpecialUserWorkAttendance()
	{
		$specialUserWorkAttendanceId = RequestTool::postParameters('special_user_work_attendance_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'special_user_work_attendance_id' => $specialUserWorkAttendanceId,
	            		'updateInfo' => $updateInfo,
	            	]
	        ]);
		}
		
		$specialUserWorkAttendanceObj = new SpecialUserWorkAttendance();
		$res = $specialUserWorkAttendanceObj->doUpdateSpecialUserWorkAttendance($specialUserWorkAttendanceId, $updateInfo);
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

}