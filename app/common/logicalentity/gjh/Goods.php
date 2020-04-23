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
                $one['skuNum'] = $goodsSkuObj->getSkuNumByGoodsID($one['goods_id']);
                $one['inventory'] = $goodsSkuObj->getInventoryByGoodsID($one['goods_id']);
                $one['goods_attributes'] = json_decode($one['goods_attributes']);
            }
            return $goodsInfo;
        }
		return false;
    }

    /**
     * 修改商品SPU信息
     */
    public function doUpdateGoods($goodsId, $saveDate)
    {
        $where = [
            ['goods_id', '=', $goodsId]
        ];
        if(!empty($saveDate['goods_name']))
        {
            $nameWhere = [
                ['goods_id', '<>', $goodsId],
                ['goods_name', '=', $saveDate['goods_name']],
                ['is_del', '=', 0],
            ];
            $otherGoodsInfo = GoodsModel::findOne($nameWhere);
        }
        
        $goodsInfo = GoodsModel::findOne($where);
        if(empty($goodsInfo) || !empty($otherGoodsInfo))
        {
            return false;
        }
        $saveDate['goods_attributes'] = isset($saveDate['goods_attributes']) ? json_encode($saveDate['goods_attributes']) : $goodsInfo['goods_attributes'];
        $res = GoodsModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加商品SPU
     */
    public function doCreateGoods($addInfo)
    {
        $addInfo['goods_attributes'] = json_encode($addInfo['goods_attributes']);
        if(GoodsModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }

    /**
     * 获取商品SPU信息
     */
    public function doGetGoods($where)
    {
        $goodsInfo = GoodsModel::findOne($where);
        if(!empty($goodsInfo))
        {
            return $goodsInfo;
        }
		return false;
    }
}