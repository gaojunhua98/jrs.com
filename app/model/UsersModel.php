<?php

namespace app\model;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 用户登陆表
 */
class UsersModel extends ModelModel
{
    protected static $connection = 'mysql';
    protected static $name = 'users';
    protected static $pk = 'uid';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneUser($where)
    {
    	return Db::name('users')->where($where)->find();
    }
}