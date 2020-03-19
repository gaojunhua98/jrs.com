<?php

namespace app\model;

use think\Model;
use think\facade\Db;

class UsersModel extends Model
{
    protected $connection = 'mysql';
    protected $name = 'users';
    protected $pk = 'uid';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    

    public static function getOneUser($loginData)
    {
    	return Db::name('users')->where($loginData)->find();
    }
}