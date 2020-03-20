<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 部门表
 */
class DepartmentModel extends Model
{
    protected $connection = 'mysql';
    protected $name = 'department';
    protected $pk = 'department_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneDepartment($where)
    {
    	return Db::name('department')->where($where)->find();
    }
}