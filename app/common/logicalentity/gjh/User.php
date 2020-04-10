<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\UserModel;

/**
 * @name 用户相关逻辑层
 */
class User
{

    /**
     * 登陆逻辑
     */
    public static function doLogin($loginData)
    {
        $where = [
			['user_name', '=', $loginData['userName']],
			['user_pwd', '=', $loginData['password']],
		];
        if($user = UserModel::findOne($where))
        {
			//登陆操作
			// session('user_name', $user['user_name']);
            session('user_id', $user['user_id']);

			cookie("user_id", $user['user_id'], time()+3600, "/", "127.0.0.1");
            return $user;
        }
		return false;
    }

    /**
     * 登陆逻辑
     */
    public static function doGetUserName($user_id)
    {
        $where = [
			['user_id', '=', $user_id],
		];
        if($user = UserModel::findOne($where))
        {
            return $user;
        }
		return false;
    }

    /**
     * 注销逻辑
     */
    public static function doLogout($userName)
    {
        if(session('user_name') == $userName)
        {
            session('user_name' , null);
            session('user_id' , null);

            cookie('user_name', null);
            return true;
        }
		return false;
    }

    /**
     * 登陆状态判断
     */
    public static function isLogin()
    {
        if(session('user_name') == cookie('user_name'))
        {
            cookie("user_name", session('user_name'), time()+3600, "/", "127.0.0.1");
            return true;
        }
		return false;
    }
    
    /**
     * 修改用户表信息
     */
    public function doUpdateUser($userId, $saveDate)
    {
        $where = [
            ['user_id', '=', $userId]
        ];
        $userInfo = UserModel::findOne($where);
        if(empty($userInfo))
        {
            return false;
        }
        $res = UserModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加用户
     */
    public function doCreateUser($addInfo)
    {
        if(UserModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }

    /**
     * 获取用户信息列表
     */
    public function doGetUserList($where, $pageData)
    {
        $userInfo = UserModel::getList($where, $pageData);
        if($userInfo)
        {
            return $userInfo;
        }
		return false;
    }

    /**
     * 获取登陆用户信息
     */
    public static function doGetUserInfo()
    {
		return session('user_id');
    }
}