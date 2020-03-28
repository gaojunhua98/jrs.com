<?php

namespace app\common\logicalentity\jrs;

use app\model\jrs\ActivityModel;

/**
 * @name 活动相关逻辑层
 */
class Activity
{
    /**
     * 获取全部活动信息
     */
    public function doGetActivityList($where, $pageData)
    {
        $activityInfo = ActivityModel::getList($where, $pageData);
        if($activityInfo)
        {
            return $activityInfo;
        }
		return false;
    }

        /**
     * 修改活动信息
     */
    public function doUpdateActivity($activityId, $saveDate)
    {
        $where = [
            ['activity_id', '=', $activityId]
        ];
        $activityInfo = ActivityModel::findOne($where);
        if(empty($activityInfo))
        {
            return false;
        }
        $res = ActivityModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加活动
     */
    public function doCreateActivity($addInfo)
    {
        if(ActivityModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}