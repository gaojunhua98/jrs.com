<?php

namespace app\model\jrs;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 部门表
 */
class DepartmentModel extends ModelModel
{
    protected $connection = 'jrs';
    protected $name = 'department';
    protected $pk = 'department_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
}