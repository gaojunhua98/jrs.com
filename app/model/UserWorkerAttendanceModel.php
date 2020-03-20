<?php

namespace app\model;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 考勤表
 */
class UserWorkerAttendanceModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'user_work_attendance';
    protected $pk = 'user_work_attendance_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneUserWorkerAttendance($where)
    {
    	return Db::name('user_work_attendance')->where($where)->find();
    }
}