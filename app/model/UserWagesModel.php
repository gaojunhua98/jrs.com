<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 工资表
 */
class UserWagesModel extends Model
{
    protected $connection = 'mysql';
    protected $name = 'user_wages';
    protected $pk = 'user_wages_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneUserWages($where)
    {
    	return Db::name('user_wages')->where($where)->find();
    }
}