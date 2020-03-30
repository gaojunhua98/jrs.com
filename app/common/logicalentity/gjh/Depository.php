<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\DepositoryModel;

/**
 * @name 仓库相关逻辑层
 */
class Depository
{
    /**
     * 获取商品信息列表
     */
    public function doGetDepositoryList($where, $pageData)
    {
        $depositoryInfo = DepositoryModel::getList($where, $pageData);
        if($depositoryInfo)
        {
            return $depositoryInfo;
        }
		return false;
    }
}