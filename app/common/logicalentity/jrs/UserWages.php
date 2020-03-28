<?php

namespace app\common\logicalentity\jrs;

use app\model\jrs\UserWagesModel;

/**
 * @name 工资相关逻辑层
 */
class UserWages
{
    /**
     * 获取全部工资信息
     */
    public function doGetUserWagesList($where, $pageData)
    {
        $userWagesInfo = UserWagesModel::getList($where, $pageData);
        if($userWagesInfo)
        {
            return $userWagesInfo;
        }
		return false;
    }

    /**
     * 修改工资信息
     */
    public function doUpdateUserWages($userWagesId, $saveDate)
    {
        $where = [
            ['user_wages_id', '=', $userWagesId]
        ];
        $userWagesInfo = UserWagesModel::findOne($where);
        if(empty($userWagesInfo))
        {
            return false;
        }
        $res = UserWagesModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加工资
     */
    public function doCreateUserWages($addInfo)
    {
        if(UserWagesModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}