<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 用户登陆表
 */
class ModelModel extends Model
{
    // protected $connection = 'jrs';
    // protected $name = 'tableName';
    // protected $pk = 'id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    //根据条件查询单条
    public static function findOne($where)
    {
    	return static::where($where)->find();
    }

    //根据条件查询多条
    public static function selectAny($where)
    {
    	return static::where($where)->select()->toArray();
    }

    //新增单条
    public static function addOne($data)
    {
    	return static::insertGetId($data);
    }

    //根据条件修改单条
    public static function updateOne($where, $data)
    {
    	return static::where($where)->save($data);
    }

    //列表页方法
    public static function getList($where, $pageData)
    {
        $list = static::where($where)
                    ->paginate($pageData['pageNum'], false, [
                        'type'     => 'Bootstrap',
                        'var_page' => 'page',
                        'page' => $pageData['page'],
            
                     ])
                     ->toArray();
        return (array)$list;
    }
}