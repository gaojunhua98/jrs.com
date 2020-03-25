<?php

namespace app\common\logicalentity;

use think\Session;
use think\Cookie;
use app\model\UserModel;
use app\model\UserInfoModel;

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
    public function doGetAllUserInfo($pageData)
    {
        $userInfoObj = new UserInfoModel();
        $userInfo = $userInfoObj->getUserInfoList($pageData);
        if($userInfo)
        {
            return $userInfo;
        }
		return false;
    }

    /**
     * 修改用户信息
     */
    public function doSaveUserInfo($userId, $saveDate)
    {
        if(is_null($userId))
        {
            $where = [
                ['user_name', '=', session('user_name')]
            ];
        } else {
            $where = [
                ['user_id', '=', $userId]
            ];
        }
        if(!UserModel::findOne($where))
        {
            return false;
        }
        $res = UserInfoModel::updateOne($where, $saveDate);
        if($res)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加用户
     */
    public function doAddUser($addInfo)
    {
        //判断用户名是否重复
        $where = [
            ['user_name', '=', $addInfo['user_name']],
        ];
        if(UserModel::findOne($where))
        {
            return false;
        }
        //处理表数据
        $userData = [
            'user_name' => $addInfo['user_name'],
            'user_pwd' => $addInfo['user_pwd'] ?: '123456',
            'user_nickname' => $addInfo['user_nickname'],
            'user_email' => $addInfo['user_email'],
            'user_phone' => $addInfo['user_phone'],
        ];
        $user_id = UserModel::addOne($userData);
        if($user_id)
        {
            $userInfoData = [
                'user_id' => $user_id,
                'user_nickname' => $addInfo['user_nickname'],
                'user_sex' => $addInfo['user_sex'],
                'user_birth' => $addInfo['user_birth'],
                'user_education' => $addInfo['user_education'],
                'user_address' => $addInfo['user_address'],
                'department_id' => $addInfo['department_id'],
                'department_name' => $addInfo['department_name'],
                'user_position' => $addInfo['user_position'],
            ];
            UserInfoModel::addOne($userInfoData);
            return true;
        }
		return false;
    }
    
}