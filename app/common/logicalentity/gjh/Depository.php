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
     * 获取仓库信息列表
     */
    public function doGetDepositoryList($where, $pageData)
    {
        $goodsSkuObj = new GoodsSku();
        $depositoryInfo = DepositoryModel::getList($where, $pageData);
        if($depositoryInfo)
        {
            foreach($depositoryInfo['data'] as &$one)
            {
                $one['skuNum'] = $goodsSkuObj->getSkuNumByDepositoryID($one['depository_id']);
                $one['inventory'] = $goodsSkuObj->getInventoryByDepositoryID($one['depository_id']);
            }
            return $depositoryInfo;
        }
		return false;
    }

    /**
     * 获取全部仓库信息
     */
    public function doGetAllDepository($where)
    {
        $depositorysInfo = DepositoryModel::selectAny($where);

        if($depositorysInfo)
        {
            return $depositorysInfo;
        }
		return false;
    }

    /**
     * 修改仓库信息
     */
    public function doUpdateDepository($depositoryId, $saveDate)
    {
        $where = [
            ['depository_id', '=', $depositoryId]
        ];
        if(!empty($saveDate['depository_name']))
        {
            $nameWhere = [
                ['depository_id', '<>', $depositoryId],
                ['depository_name', '=', $saveDate['depository_name']],
                ['is_del', '=', 0],
            ];
            $otherDepositoryInfo = DepositoryModel::findOne($nameWhere);
        }
        $depositoryInfo = DepositoryModel::findOne($where);
        if(empty($depositoryInfo) || !empty($otherDepositoryInfo))
        {
            return false;
        }
        $res = DepositoryModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加仓库
     */
    public function doCreateDepository($addInfo)
    {
        $where = [
            ['depository_name', '=', $addInfo['depository_name']],
            ['is_del', '=', 0],
        ];
        $depositoryInfo = DepositoryModel::findOne($where);
        if(!empty($depositoryInfo))
        {
            return false;
        }
        if(DepositoryModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}