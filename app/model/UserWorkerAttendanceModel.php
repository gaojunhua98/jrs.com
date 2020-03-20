<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 考勤表
 */
class UserWorkerAttendanceModel extends Model
{
    protected $connection = 'mysql';
    protected $name = 'user_work_attendance';
    protected $pk = 'user_work_attendance_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    //根据条件查询单条
    public static function findOne($where)
    {
    	return Db::name($name)->where($where)->find();
    }

    //根据条件查询多条
    public static function selectAny($where)
    {
    	return Db::name($name)->where($where)->select()->toArray();
    }

    //新增单条
    public static function addOne($data)
    {
    	return Db::name($name)->save($data);
    }

    //根据条件修改单条
    public static function updateOne($where, $data)
    {
    	return Db::name($name)->where($where)->save($data);
    }

    //列表页方法
    public static function getList($where, $pageData)
    {
        $list = Db::name('users')
                    ->where($where)
                    ->paginate($pageData['pageNum'], false, [
                        'type'     => 'Bootstrap',
                        'var_page' => 'page',
                        'page' => $pageData['page'],
            
                     ]);
        return $res = [
            'list' => $list,
        ];
    }
}