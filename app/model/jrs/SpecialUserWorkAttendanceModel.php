<?php

namespace app\model\jrs;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 特殊考勤表
 */
class SpecialUserWorkAttendanceModel extends ModelModel
{
    protected $connection = 'jrs';
    protected $name = 'special_user_work_attendance';
    protected $pk = 'special_user_work_attendance_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }

}