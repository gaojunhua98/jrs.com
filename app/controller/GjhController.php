<?php

namespace app\controller;

use app\controller\ControllerController;
use app\common\tool\Page;
use app\common\tool\RequestTool;
use app\common\logicalentity\gjh\User;
use app\common\logicalentity\gjh\Attributes;
use app\common\logicalentity\gjh\Depository;
use app\common\logicalentity\gjh\Goods;
use app\common\logicalentity\gjh\GoodsSku;
use app\common\logicalentity\gjh\Shop;

class GjhController extends ControllerController
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
	//响应user请求接口
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

	//修改密码接口
	public function UpdateUser()
	{
		$userId = RequestTool::postParameters('user_id');
		$updateInfo = RequestTool::postParameters('updateInfo');
		if(empty($updateInfo)) 
		{
			return  json([
				'code' => -1001,
				'msg' => '缺少参数',
				'data' => [
						'user_id' => $userId,
						'updateInfo' => $updateInfo,
					]
			]);
		}
		
		$userObj = new User();
		$res = $userObj->doUpdateUser($userId, $updateInfo);
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

	//TODO 获取用户列表
	public function getUserList()
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
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];

		$list = $userObj->doGetUserList($where,$pageData);
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
	
	//TODO 获取店铺列表
	public function getShopList()
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
		$shopObj = new Shop();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];

		$list = $shopObj->doGetShopList($where,$pageData);
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

	//TODO 获取仓库列表
	public function getDepositoryList()
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
		$depositoryObj = new Depository();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];

		$list = $depositoryObj->doGetDepositoryList($where,$pageData);
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
	//TODO 获取属性列表
	public function getAttributesList()
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
		$attributesObj = new Attributes();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];

		$list = $attributesObj->doGetAttributesList($where,$pageData);
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

	//TODO 获取商品SPU列表
	public function getGoodsList()
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
		$goodsObj = new Goods();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];

		$list = $goodsObj->doGetGoodsList($where,$pageData);
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
	//TODO 获取商品SKU列表
	public function getGoodsSkuList()
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
		$goodsSkuObj = new GoodsSku();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];

		$list = $goodsSkuObj->doGetGoodsSkuList($where,$pageData);
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
}