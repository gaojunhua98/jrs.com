<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\GoodsModel;
use app\model\gjh\GoodsSkuModel;
use app\model\gjh\AttributesModel;
use app\model\gjh\AttributesValueModel;

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
                $one['selectList'] = $this->doGetSelectList($one['goods_id']);
                $one['sku_attributes'] = $this->getValuesByJson($one['sku_attributes']);
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

    /**
     * @name  根据Json获取属性
     */
    public function getValuesByJson($attributes)
    {
        $return = [];
        $attributes = (array)json_decode($attributes);
        if(!empty($attributes))
        {
            foreach($attributes as $key => $value)
            {
                $return[] = $key . ':' . $value;
            }
            return $return;
        }
        return false;
    }

    /**
     * @name 通过goodsId获取选项
     */
    public function doGetSelectList($goodsId)
    {
        $selectList = [];
        $where = [
            ['goods_id', '=', $goodsId],
            ['is_del', '=', 0],
        ];
        $goodsInfo = GoodsModel::findOne($where);
        $goodsAattributes = json_decode($goodsInfo['goods_attributes']);

        foreach($goodsAattributes as $oneAattributes)
        {
            $attributesWhere = [
                ['attributes_name', '=', $oneAattributes],
                ['is_del', '=', 0],
            ];
            $attributesInfo = AttributesModel::findOne($attributesWhere);
            $attributesValueWhere = [
                ['attributes_id', '=', $attributesInfo['attributes_id']],
                ['is_del', '=', 0],
            ];
            $attributesValueInfos = AttributesValueModel::selectAny($attributesValueWhere);
            foreach($attributesValueInfos as $oneAttributesValue)
            {
                $selectList[] = ['value' => $oneAattributes . ':' . $oneAttributesValue['attributes_value']];
            }
        }

        return $selectList;
    }

    /**
     * @name 通过goodsName获取选项
     */
    public function doGetAttributesByGoodsName($goodsName)
    {
        $selectList = [];
        $where = [
            ['goods_name', '=', $goodsName],
            ['is_del', '=', 0],
        ];
        $goodsInfo = GoodsModel::findOne($where);
        $goodsAattributes = json_decode($goodsInfo['goods_attributes']);

        foreach($goodsAattributes as $oneAattributes)
        {
            $attributesWhere = [
                ['attributes_name', '=', $oneAattributes],
                ['is_del', '=', 0],
            ];
            $attributesInfo = AttributesModel::findOne($attributesWhere);
            $attributesValueWhere = [
                ['attributes_id', '=', $attributesInfo['attributes_id']],
                ['is_del', '=', 0],
            ];
            $attributesValueInfos = AttributesValueModel::selectAny($attributesValueWhere);
            foreach($attributesValueInfos as $oneAttributesValue)
            {
                $selectList[] = ['value' => $oneAattributes . ':' . $oneAttributesValue['attributes_value']];
            }
        }

        return $selectList;
    }
}