<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\ShopModel;
use app\common\logicalentity\gjh\GoodsSku;

/**
 * @name 店铺相关逻辑层
 */
class Shop
{
    /**
     * 获取店铺信息列表
     */
    public function doGetShopList($where, $pageData)
    {
        $goodsSkuObj = new GoodsSku();
        $shopInfo = ShopModel::getList($where, $pageData);
        if($shopInfo)
        {
            foreach($shopInfo['data'] as &$one)
            {
                $one['skuNum'] = $goodsSkuObj->getSkuNumByShopId($one['shop_id']);
                $one['inventory'] = $goodsSkuObj->getInventoryByShopId($one['shop_id']);
            }
            return $shopInfo;
        }
		return false;
    }

        /**
     * 修改店铺信息
     */
    public function doUpdateShop($shopId, $saveDate)
    {
        $where = [
            ['shop_id', '=', $shopId]
        ];
        $shopInfo = ShopModel::findOne($where);
        if(empty($shopInfo))
        {
            return false;
        }
        $res = ShopModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加店铺
     */
    public function doCreateShop($addInfo)
    {
        if(ShopModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}