<?php

namespace app\common\logicalentity;

use think\Session;
use think\Cookie;
use app\model\UserModel;

/**
 * @name 用户相关逻辑层
 */
class User
{

    /**
     * 登陆操作
     */
    public static function doLogin($loginData)
    {
        $loginData = [
			['user_name', '=', $loginData['user_name']],
			['user_pwd', '=', $loginData['user_pwd']],
		];
        if($user = UserModel::findOne($loginData))
        {
			//TODO 登陆操作
			session('[start]');
			session('user_nickname', $user['user_nickname']);
			session('user_name', $user['user_name']);
			setcookie("jrsToken", 'gaojunhua98', time()+3600, "/", "127.0.0.1");
            return $user;
        }
		return false;
    }

}