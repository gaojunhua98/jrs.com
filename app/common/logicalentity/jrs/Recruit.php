<?php

namespace app\common\logicalentity\jrs;

use app\model\jrs\RecruitModel;

/**
 * @name 招聘相关逻辑层
 */
class Recruit
{
    /**
     * 获取全部招聘信息
     */
    public function doGetRecruitList($where, $pageData)
    {
        $recruitInfo = RecruitModel::getList($where, $pageData);
        if($recruitInfo)
        {
            return $recruitInfo;
        }
		return false;
    }

    /**
     * 修改招聘信息
     */
    public function doUpdateRecruit($recruitId, $saveDate)
    {
        $where = [
            ['recruit_id', '=', $recruitId]
        ];
        $recruitInfo = RecruitModel::findOne($where);
        if(empty($recruitInfo))
        {
            return false;
        }
        $res = RecruitModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加招聘
     */
    public function doCreateRecruit($addInfo)
    {
        if(RecruitModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}