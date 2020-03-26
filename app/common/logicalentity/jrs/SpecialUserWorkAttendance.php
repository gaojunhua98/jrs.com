<?php

namespace app\common\logicalentity\jrs;

use app\model\jrs\SpecialUserWorkAttendanceModel;

/**
 * @name 特殊考勤相关逻辑层
 */
class SpecialUserWorkAttendance
{
    /**
     * 获取全部特殊考勤信息
     */
    public function doGetSpecialUserWorkAttendanceList($where, $pageData)
    {
        $specialUserWorkAttendanceModelInfo = SpecialUserWorkAttendanceModel::getList($where, $pageData);
        if($specialUserWorkAttendanceModelInfo)
        {
            return $specialUserWorkAttendanceModelInfo;
        }
		return false;
    }

    /**
     * 修改特殊考勤信息
     */
    public function doUpdateSpecialUserWorkAttendance($specialUserWorkAttendanceId, $saveDate)
    {
        $where = [
            ['special_user_work_attendance_id', '=', $specialUserWorkAttendanceId]
        ];
        $specialUserWorkAttendanceModelInfo = SpecialUserWorkAttendanceModel::findOne($where);
        if(empty($specialUserWorkAttendanceModelInfo))
        {
            return false;
        }
        $res = SpecialUserWorkAttendanceModel::updateOne($where, $saveDate);
        if($res)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加特殊考勤
     */
    public function doCreateSpecialUserWorkAttendance($addInfo)
    {
        if(SpecialUserWorkAttendanceModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}