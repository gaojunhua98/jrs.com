<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\GoodsSkuModel;

/**
 * @name 商品SKU相关逻辑层
 */
class GoodsSku
{
    /**
     * 获取商品SKU信息列表
     */
    public function doGetGoodsSkuList($where, $pageData)
    {
        $goodsSkuInfo = GoodsSkuModel::getList($where, $pageData);
        if($goodsSkuInfo)
        {
            return $goodsSkuInfo;
        }
		return false;
    }
}