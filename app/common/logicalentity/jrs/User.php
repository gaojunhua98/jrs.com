<?php

namespace app\common\logicalentity\jrs;

use think\Session;
use think\Cookie;
use app\model\jrs\UserModel;
use app\model\jrs\UserInfoModel;

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
			session('user_name', $user['user_name']);
            session('user_nickname', $user['user_nickname']);

			cookie("user_name", $user['user_name'], time()+3600, "/", "127.0.0.1");
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
            session('user_nickname' , null);

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
     * 获取当前用户信息
     */
    public function doGetLogUserInfo()
    {
        $where = [
            ['user_name', '=', session('user_name')]
        ];
        $userInfo = UserInfoModel::findOne($where);
        if($userInfo)
        {
            return $userInfo;
        }
		return false;
    }

    /**
     * 获取全部用户信息
     */
    public function doGetAllUserInfo($where, $pageData)
    {
        $userInfo = UserInfoModel::getList($where, $pageData);
        if($userInfo)
        {
            return $userInfo;
        }
		return false;
    }

    /**
     * 修改用户信息表信息
     */
    public function doSaveUserInfo($userInfoId, $saveDate)
    {
        $where = [
            ['user_info_id', '=', $userInfoId]
        ];
        $userInfo = UserInfoModel::findOne($where);
        if(empty($userInfo))
        {
            return false;
        }
        $res = UserInfoModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加用户信息表
     */
    public function doAddUser($addInfo)
    {
        //判断用户名是否重复
        // $where = [
        //     ['user_nickname', '=', $addInfo['user_nickname']],
        // ];
        // $userInfo = UserInfoModel::findOne($where);
        // if(!empty($userInfo))
        // {
        //     return false;
        // }
        if(UserInfoModel::addOne($addInfo))
        {
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
}