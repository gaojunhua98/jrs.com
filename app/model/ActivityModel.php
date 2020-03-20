<?php

namespace app\model;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 活动表
 */
class ActivityModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'activity';
    protected $pk = 'activity_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneActivity($where)
    {
    	return Db::name('activity')->where($where)->find();
    }
}