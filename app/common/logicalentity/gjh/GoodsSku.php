<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\ShopModel;
use app\model\gjh\GoodsModel;
use app\model\gjh\GoodsSkuModel;
use app\model\gjh\DepositoryModel;
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
                $one['selectList'] = $this->doGetAttributesByGoodsID($one['goods_id']);
                // $one['sku_attributes'] = $this->getValuesByJson($one['sku_attributes']);
                $one['sku_attributes'] = json_decode($one['sku_attributes']);
                $one = $this->delSkuData($one);
            }
            
            return $goodsSkuInfo;
        }
		return false;
    }

    /**
     * 修改商品SKU信息
     */
    public function doUpdateGoodsSku($goodsSkuId, $saveData)
    {
        $where = [
            ['goods_sku_id', '=', $goodsSkuId]
        ];
        $goodsSkuInfo = GoodsSkuModel::findOne($where);
        if(empty($goodsSkuInfo))
        {
            return false;
        }
        $saveData['sku_attributes'] = isset($saveData['sku_attributes']) ? json_encode($saveData['sku_attributes']) : $goodsSkuInfo['sku_attributes'];;
        $res = GoodsSkuModel::updateOne($where, $saveData);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加商品SKU
     */
    public function doCreateGoodsSku($addData)
    {
        $addData['sku_attributes'] = json_encode($addData['sku_attributes']);
        if(GoodsSkuModel::addOne($addData))
        {
            return true;
        }
		return false;
    }

    /**
     * 处理SKU信息
     */
    public function delSkuData($data)
    {
        $goodsWhere = [
            ['goods_id', '=', $data['goods_id']]
        ];
        $goodsInfo = GoodsModel::findOne($goodsWhere);

        $shopWhere = [
            ['shop_id', '=', $data['shop_id']]
        ];
        $shopInfo = ShopModel::findOne($shopWhere);

        $depositoryWhere = [
            ['depository_id', '=', $data['depository_id']]
        ];
        $depositoryInfo = DepositoryModel::findOne($depositoryWhere);

        $data['goods_name'] = $goodsInfo['goods_name'];
        $data['shop_name'] = $shopInfo['shop_name'];
        $data['depository_name'] = $depositoryInfo['depository_name'];
        
        return $data;
    }


    /**
     * @name 通过店铺获取SKU量
     */
    public function getSkuNumByShopID($shopID)
    {
        $where = [
            ['shop_id', '=', $shopID],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetSkuNum($where);
        return $count;
    }

    /**
     * @name 通过仓库获取SKU量
     */
    public function getSkuNumByDepositoryID($depositoryID)
    {
        $where = [
            ['depository_id', '=', $depositoryID],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetSkuNum($where);
        return $count;
    }


    /**
     * @name 通过商品获取SKU量
     */
    public function getSkuNumByGoodsID($goodsID)
    {
        $where = [
            ['goods_id', '=', $goodsID],
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
    public function getInventoryByShopID($shopID)
    {
        $where = [
            ['shop_id', '=', $shopID],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetInventory($where);
        return $count;
    }

    /**
     * @name 通过仓库获取库存量
     */
    public function getInventoryByDepositoryID($depositoryID)
    {
        $where = [
            ['depository_id', '=', $depositoryID],
            ['is_del', '=', 0],
        ];
        $count = $this->doGetInventory($where);
        return $count;
    }


    /**
     * @name 通过商品获取库存量
     */
    public function getInventoryByGoodsID($goodsID)
    {
        $where = [
            ['goods_id', '=', $goodsID],
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
        // $attributes = json_decode($attributes);
        var_dump($attributes, (array)$attributes);
        die;
        if(!empty($attributes))
        {
            foreach($attributes as $value)
            {
                $return[] = $value;
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
        var_dump($goodsAattributes);
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
    public function doGetAttributesByGoodsID($goodsID)
    {
        $selectList = [];
        $where = [
            ['goods_id', '=', $goodsID],
            ['is_del', '=', 0],
        ];
        $goodsInfo = GoodsModel::findOne($where);
        $goodsAattributes = json_decode($goodsInfo['goods_attributes']);
        
        if(array($goodsAattributes))
        {
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
        }

        return $selectList;
    }
}