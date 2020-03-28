<?php

namespace app\common\logicalentity\jrs;

use app\model\jrs\UserWorkAttendanceModel;

/**
 * @name 考勤相关逻辑层
 */
class UserWorkAttendance
{
    /**
     * 获取全部考勤信息
     */
    public function doGetUserWorkAttendanceList($where, $pageData)
    {
        $userWorkAttendanceInfo = UserWorkAttendanceModel::getList($where, $pageData);
        if($userWorkAttendanceInfo)
        {
            return $userWorkAttendanceInfo;
        }
		return false;
    }

    /**
     * 修改考勤信息
     */
    public function doUpdateUserWorkAttendance($userWorkAttendanceId, $saveDate)
    {
        $where = [
            ['user_work_attendance_id', '=', $userWorkAttendanceId]
        ];
        $userWorkAttendanceInfo = UserWorkAttendanceModel::findOne($where);
        if(empty($userWorkAttendanceInfo))
        {
            return false;
        }
        $res = UserWorkAttendanceModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加考勤
     */
    public function doCreateUserWorkAttendance($addInfo)
    {
        if(UserWorkAttendanceModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}