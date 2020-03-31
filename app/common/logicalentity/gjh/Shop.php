<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\ShopModel;

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
        $shopInfo = ShopModel::getList($where, $pageData);
        if($shopInfo)
        {
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