<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\GoodsModel;
use app\common\logicalentity\gjh\GoodsSku;

/**
 * @name 商品相关逻辑层
 */
class Goods
{
    /**
     * 获取商品信息列表
     */
    public function doGetGoodsList($where, $pageData)
    {
        $goodsSkuObj = new GoodsSku();
        $goodsInfo = GoodsModel::getList($where, $pageData);
        if($goodsInfo)
        {
            foreach($goodsInfo['data'] as &$one)
            {
                $one['skuNum'] = $goodsSkuObj->getSkuNumByGoodsId($one['goods_id']);
                $one['inventory'] = $goodsSkuObj->getInventoryByGoodsId($one['goods_id']);
                $one['goods_attributes'] = json_decode($one['goods_attributes']);
            }
            return $goodsInfo;
        }
		return false;
    }
}