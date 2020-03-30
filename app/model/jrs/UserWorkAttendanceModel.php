<?php

namespace app\model\jrs;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 考勤表
 */
class UserWorkAttendanceModel extends ModelModel
{
    protected $connection = 'jrs';
    protected $name = 'user_work_attendance';
    protected $pk = 'user_work_attendance_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
}