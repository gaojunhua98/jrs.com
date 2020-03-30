<?php

namespace app\model\jrs;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 活动表
 */
class ActivityModel extends ModelModel
{
    protected $connection = 'jrs';
    protected $name = 'activity';
    protected $pk = 'activity_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
}