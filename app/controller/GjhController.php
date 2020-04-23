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
						'id' => User::doGetUserInfo(),
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
					'username' => $user['user_name'],
					'power' => $user['power'] == 1 ? 'admin' : 'user'
				]
			]);
		}
		return  json([
            'code' => 1,
            'msg' => '获取失败',
            'data' => ''
        ]);
        
	}

	// 获取用户列表
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

	// 更新用户
	public function saveUser()
	{
		$userId = RequestTool::postParameters('user_id');
		$saveInfo = RequestTool::postParameters('saveInfo');
		if(empty($saveInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'user_id' => $userId,
	            		'saveInfo' => $saveInfo,
	            	]
	        ]);
		}
		$userObj = new User();
		if(empty($userId))
		{
			$res = $userObj->doCreateUser($saveInfo);
		} else {
			$res = $userObj->doUpdateUser($userId, $saveInfo);
		}

		if($res){
			return  json([
	            'code' => 1,
	            'msg' => '操作成功',
	            'data' => []
	        ]);
		}
		return  json([
			'code' => -2001,
			'msg' => '操作失败',
			'data' => []
		]);
	}

	// 获取全部店铺
	public function getAllShops()
	{
		$query = json_decode(RequestTool::getParameters('query'));
		$user_id = json_decode(RequestTool::getParameters('user_id'));
		$shopObj = new Shop();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];
		$where[] = ['user_id', '=', $user_id];

		$list = $shopObj->doGetAllShop($where);
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

	// 获取店铺列表
	public function getShopList()
	{
		$pageData = Page::getPageParameters();
		$query = json_decode(RequestTool::getParameters('query'));
		$user_id = json_decode(RequestTool::getParameters('user_id'));
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
		$where[] = ['user_id', '=', $user_id];

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

	// 更新店铺
	public function saveShop()
	{
		$shopId = RequestTool::postParameters('shop_id');
		$saveInfo = RequestTool::postParameters('saveInfo');
		if(empty($saveInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'shop_id' => $shopId,
	            		'saveInfo' => $saveInfo,
	            	]
	        ]);
		}
		$shopObj = new Shop();
		if(empty($shopId))
		{
			$res = $shopObj->doCreateShop($saveInfo);
		} else {
			$res = $shopObj->doUpdateShop($shopId, $saveInfo);
		}

		if($res){
			return  json([
	            'code' => 1,
	            'msg' => '操作成功',
	            'data' => []
	        ]);
		}
		return  json([
			'code' => -2001,
			'msg' => '操作失败',
			'data' => []
		]);
	}

	// 获取全部仓库
	public function getAllDepositorys()
	{
		$query = json_decode(RequestTool::getParameters('query'));
		$user_id = json_decode(RequestTool::getParameters('user_id'));
		$depositoryObj = new Depository();
		$where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];
		$where[] = ['user_id', '=', $user_id];

		$list = $depositoryObj->doGetAllDepository($where);
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

	// 获取仓库列表
	public function getDepositoryList()
	{
		$pageData = Page::getPageParameters();
		$query = json_decode(RequestTool::getParameters('query'));
		$user_id = json_decode(RequestTool::getParameters('user_id'));
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
		$where[] = ['user_id', '=', $user_id];

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

	// 更新仓库
	public function saveDepository()
	{
		$depositoryId = RequestTool::postParameters('depository_id');
		$saveInfo = RequestTool::postParameters('saveInfo');
		if(empty($saveInfo)) 
    	{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少参数',
	            'data' => [
	            		'depository_id' => $depositoryId,
	            		'saveInfo' => $saveInfo,
	            	]
	        ]);
		}
		$depositoryObj = new Depository();
		if(empty($depositoryId))
		{
			$res = $depositoryObj->doCreateDepository($saveInfo);
		} else {
			$res = $depositoryObj->doUpdateDepository($depositoryId, $saveInfo);
		}

		if($res){
			return  json([
	            'code' => 1,
	            'msg' => '操作成功',
	            'data' => []
	        ]);
		}
		return  json([
			'code' => -2001,
			'msg' => '操作失败',
			'data' => []
		]);
	}

	// 获取属性列表
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

	// 更新属性
	public function saveAttributes()
	{
		$attributesId = RequestTool::postParameters('attributes_id');
		$saveInfo = RequestTool::postParameters('saveInfo');
		if(empty($saveInfo)) 
		{
			return  json([
				'code' => -1001,
				'msg' => '缺少参数',
				'data' => [
						'attributes_id' => $attributesId,
						'saveInfo' => $saveInfo,
					]
			]);
		}
		$attributesObj = new Attributes();
		if(empty($attributesId))
		{
			$res = $attributesObj->doCreateAttributes($saveInfo);
		} else {
			$res = $attributesObj->doUpdateAttributes($attributesId, $saveInfo);
		}

		if($res){
			return  json([
				'code' => 1,
				'msg' => '操作成功',
				'data' => []
			]);
		}
		return  json([
			'code' => -2001,
			'msg' => '操作失败',
			'data' => []
		]);
	}

	// 获取全部属性
	public function getAllAttributes()
	{
		// $query = json_decode(RequestTool::getParameters('query'));

		// $where = $this->getWhere($query);
		$where[] = ['is_del', '=', 0];
		$attributesObj = new Attributes();
		$list = $attributesObj->doGetAllAttributes($where);
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

	// 获取商品SPU列表
	public function getGoodsList()
	{
		$pageData = Page::getPageParameters();
		$query = json_decode(RequestTool::getParameters('query'));
		$user_id = json_decode(RequestTool::getParameters('user_id'));
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
		$where[] = ['user_id', '=', $user_id];

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

	// 更新商品SPU
	public function saveGoods()
	{
		$goodsId = RequestTool::postParameters('goods_id');
		$saveInfo = RequestTool::postParameters('saveInfo');
		if(empty($saveInfo)) 
		{
			return  json([
				'code' => -1001,
				'msg' => '缺少参数',
				'data' => [
						'goods_id' => $goodsId,
						'saveInfo' => $saveInfo,
					]
			]);
		}
		$goodsObj = new Goods();
		if(empty($goodsId))
		{
			$res = $goodsObj->doCreateGoods($saveInfo);
		} else {
			$res = $goodsObj->doUpdateGoods($goodsId, $saveInfo);
		}

		if($res){
			return  json([
				'code' => 1,
				'msg' => '操作成功',
				'data' => []
			]);
		}
		return  json([
			'code' => -2001,
			'msg' => '操作失败',
			'data' => []
		]);
	}

	// 获取商品SKU列表
	public function getGoodsSkuList()
	{
		$skuWhere = [];
		$pageData = Page::getPageParameters();
		$query = json_decode(RequestTool::getParameters('query'));
		$user_id = json_decode(RequestTool::getParameters('user_id'));
		if(!$pageData)
		{
	    	return  json([
	            'code' => -1001,
	            'msg' => '缺少分页参数',
	            'data' => []
	        ]);
		}
		$goodsObj = new Goods();
		$goodsSkuObj = new GoodsSku();

		$spuWhere = $this->getWhere($query);
		$spuWhere[] = ['is_del', '=', 0];
		$spuWhere[] = ['user_id', '=', $user_id];
		$spuInfo = $goodsObj->doGetGoods($spuWhere);

		$skuWhere[] = ['goods_id', '=', $spuInfo['goods_id']];
		$skuWhere[] = ['is_del', '=', 0];
		$skuWhere[] = ['user_id', '=', $user_id];

		$list = $goodsSkuObj->doGetGoodsSkuList($skuWhere,$pageData);
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

	// 更新商品SKU
	public function saveGoodsSku()
	{
		$goodsSkuId = RequestTool::postParameters('goods_sku_id');
		$saveInfo = RequestTool::postParameters('saveInfo');
		if(empty($saveInfo)) 
		{
			return  json([
				'code' => -1001,
				'msg' => '缺少参数',
				'data' => [
						'goods_sku_id' => $goodsSkuId,
						'saveInfo' => $saveInfo,
					]
			]);
		}
		$goodsSkuObj = new GoodsSku();
		if(empty($goodsSkuId))
		{
			$res = $goodsSkuObj->doCreateGoodsSku($saveInfo);
		} else {
			$res = $goodsSkuObj->doUpdateGoodsSku($goodsSkuId, $saveInfo);
		}

		if($res){
			return  json([
				'code' => 1,
				'msg' => '操作成功',
				'data' => []
			]);
		}
		return  json([
			'code' => -2001,
			'msg' => '操作失败',
			'data' => []
		]);
	}

	// 根据商品名获取可选属性
	public function getAttributesByGoodsName()
	{
		$goodsID = RequestTool::getParameters('goods_id');
		if(empty($goodsID)) 
		{
			return  json([
				'code' => -1001,
				'msg' => '缺少参数',
				'data' => [
						'goods_id' => $goodsID,
					]
			]);
		}
		$goodsSkuObj = new GoodsSku();
		$res = $goodsSkuObj->doGetAttributesByGoodsID($goodsID);

		if($res){
			return  json([
				'code' => 1,
				'msg' => '获取成功',
				'data' => $res
			]);
		}
		return  json([
			'code' => -2001,
			'msg' => '获取失败',
			'data' => []
		]);
	}
}