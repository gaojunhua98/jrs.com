<?php

namespace app\model\jrs;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 活动表
 */
class RecruitModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'recruit';
    protected $pk = 'recruit_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
}