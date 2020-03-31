<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\DepositoryModel;
use app\common\logicalentity\gjh\GoodsSku;

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
        $goodsSkuObj = new GoodsSku();
        $depositoryInfo = DepositoryModel::getList($where, $pageData);
        if($depositoryInfo)
        {
            foreach($depositoryInfo['data'] as &$one)
            {
                $one['skuNum'] = $goodsSkuObj->getSkuNumByDepositoryId($one['depository_id']);
                $one['inventory'] = $goodsSkuObj->getInventoryByDepositoryId($one['depository_id']);
            }
            return $depositoryInfo;
        }
		return false;
    }
}