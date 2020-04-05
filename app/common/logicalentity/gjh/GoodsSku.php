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
            foreach($goodsSkuInfo['data'] as &$one)
            {
                $one['sku_attributes'] = [
                    '材质:金属',
                    '颜色:红色',
                    '尺寸:11',
                ];
            }
            return $goodsSkuInfo;
        }
		return false;
    }

    /**
     * 修改商品SKU信息
     */
    public function doUpdateGoodsSku($goodsSkuId, $saveDate)
    {
        $where = [
            ['goods_sku_id', '=', $goodsSkuId]
        ];
        $goodsSkuInfo = GoodsSkuModel::findOne($where);
        if(empty($goodsSkuInfo))
        {
            return false;
        }
        $saveDate['sku_attributes'] = isset($saveDate['sku_attributes']) ? json_encode($saveDate['sku_attributes']) : $goodsSkuInfo['sku_attributes'];;
        $res = GoodsSkuModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加商品SKU
     */
    public function doCreateGoodsSku($addInfo)
    {
        $addInfo['sku_attributes'] = json_encode($addInfo['sku_attributes']);
        if(GoodsSkuModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }

    /**
     * @name 通过店铺获取SKU量
     */
    public function getSkuNumByShopId($shopId)
    {
        $where = [
            ['shop_id', '=', $shopId],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetSkuNum($where);
        return $count;
    }

    /**
     * @name 通过仓库获取SKU量
     */
    public function getSkuNumByDepositoryId($depositoryId)
    {
        $where = [
            ['depository_id', '=', $depositoryId],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetSkuNum($where);
        return $count;
    }


    /**
     * @name 通过商品获取SKU量
     */
    public function getSkuNumByGoodsId($goodsId)
    {
        $where = [
            ['goods_id', '=', $goodsId],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetSkuNum($where);
        return $count;
    }

    /**
     * @name  根据条件获取SKU量
     */
    public function doGetSkuNum($where)
    {
        return GoodsSkuModel::getCount($where);
    }

    /**
     * @name 通过店铺获取库存量
     */
    public function getInventoryByShopId($shopId)
    {
        $where = [
            ['shop_id', '=', $shopId],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetInventory($where);
        return $count;
    }

    /**
     * @name 通过仓库获取库存量
     */
    public function getInventoryByDepositoryId($depositoryId)
    {
        $where = [
            ['depository_id', '=', $depositoryId],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetInventory($where);
        return $count;
    }


    /**
     * @name 通过商品获取库存量
     */
    public function getInventoryByGoodsId($goodsId)
    {
        $where = [
            ['goods_id', '=', $goodsId],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetInventory($where);
        return $count;
    }

    /**
     * @name  根据条件获取库存量
     */
    public function doGetInventory($where)
    {
        $inventory = 0;
        $skuInfos = GoodsSkuModel::selectAny($where);
        if(!empty($skuInfos))
        {
            foreach($skuInfos as $one)
            {
                $inventory += $one['sku_num'];
            }
        }

        return $inventory;
    }
}