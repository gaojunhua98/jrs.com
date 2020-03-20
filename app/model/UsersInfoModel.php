<?php

namespace app\model;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 用户信息表
 */
class UsersInfoModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'users_info';
    protected $pk = 'users_info_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneUserInfo($where)
    {
    	return Db::name('users_info')->where($where)->find();
    }
}