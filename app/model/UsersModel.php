<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 用户登陆表
 */
class UsersModel extends Model
{
    protected $connection = 'mysql';
    protected $name = 'users';
    protected $pk = 'uid';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    //根据条件查询单条
    public static function findOne($where)
    {
    	return Db::name('users')->where($where)->find();
    }

    //根据条件查询多条
    public static function selectAny($where)
    {
    	return Db::name('users')->where($where)->select()->toArray();
    }

    //新增单条
    public static function addOne($data)
    {
    	return Db::name('users')->save($data);
    }

    //根据条件修改单条
    public static function updateOne($where, $data)
    {
    	return Db::name('users')->where($where)->save($data);
    }

    //列表页方法
    public static function getList($where, $pageNum)
    {
        $total = Db::name('users')->where($where)->count();
        $list = Db::name('users')
                    ->where($where)
                    ->paginate($pageNum, false, $total);
        return $res = [
            'list' => $list,
        ];
    }
}