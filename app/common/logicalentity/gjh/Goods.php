<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\GoodsModel;

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
        $goodsInfo = GoodsModel::getList($where, $pageData);
        if($goodsInfo)
        {
            return $goodsInfo;
        }
		return false;
    }
}