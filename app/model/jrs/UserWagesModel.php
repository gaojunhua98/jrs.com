<?php

namespace app\model\jrs;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 工资表
 */
class UserWagesModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'user_wages';
    protected $pk = 'user_wages_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
}