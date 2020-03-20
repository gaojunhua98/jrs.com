<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 继承基础模型类
 */
class ModelModel extends Model
{
    protected static $connection = 'mysql';
    protected static $name = 'name';
//TODO 模型公共方法

    //TODO 根据条件查询单条
    public static function findOne($where)
    {
    	return Db::name($name)->where($where)->find();
    }

    //TODO 根据条件查询多条
    public static function selectAny($where)
    {
    	return Db::name($name)->where($where)->find();
    }

    //TODO 新增单条
    public static function addOne($data)
    {
    	return Db::name($name)->where($where)->find();
    }

    //TODO 根据条件修改单条
    public static function updateOne($where)
    {
    	return Db::name($name)->where($where)->find();
    }
}