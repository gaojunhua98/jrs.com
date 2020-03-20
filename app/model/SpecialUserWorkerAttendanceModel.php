<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * @name 特殊考勤表
 */
class SpecialUserWorkerAttendanceModel extends Model
{
    protected $connection = 'mysql';
    protected $name = 'special_user_work_attendance';
    protected $pk = 'special_user_work_attendance_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
    public static function getOneSpecialUserWorkerAttendance($where)
    {
    	return Db::name('special_user_work_attendance')->where($where)->find();
    }
}