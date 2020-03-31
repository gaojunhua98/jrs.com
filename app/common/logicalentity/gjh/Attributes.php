<?php

namespace app\common\logicalentity\gjh;

use think\Session;
use think\Cookie;
use app\model\gjh\AttributesModel;
use app\model\gjh\AttributesValueModel;

/**
 * @name 属性相关逻辑层
 */
class Attributes
{
    /**
     * 获取属性信息列表
     */
    public function doGetAttributesList($where, $pageData)
    {
        $attributesInfo = AttributesModel::getList($where, $pageData);

        if($attributesInfo)
        {
            foreach($attributesInfo['data'] as &$one)
            {
                $where = [
                    ['attributes_id', '=', $one['attributes_id']],
                    ['is_del', '=', 0],
                ];
                $one['values'] = AttributesValueModel::selectAny($where);
            }
            return $attributesInfo;
        }
		return false;
    }

    /**
     * 获取全部属性信息
     */
    public function doGetAllAttributes($where)
    {
        $attributesInfo = AttributesModel::selectAny($where);

        if($attributesInfo)
        {
            foreach($attributesInfo as &$one)
            {
                $where = [
                    ['attributes_id', '=', $one['attributes_id']],
                    ['is_del', '=', 0],
                ];
                $one['values'] = AttributesValueModel::selectAny($where);
            }
            return $attributesInfo;
        }
		return false;
    }
}