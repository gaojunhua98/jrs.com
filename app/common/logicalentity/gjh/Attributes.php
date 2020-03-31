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
     * 获取商品信息列表
     */
    public function doGetAttributesList($where, $pageData)
    {
        $attributesInfo = AttributesModel::getList($where, $pageData);
        var_dump($attributesInfo->total,$attributesInfo->per_page);
        die;
        foreach($attributesInfo->data as &$one)
        {
            $where = [
                ['attributes_id', '=', $one['attributes_id']],
                ['is_del', '=', 0],
            ];
            $one['values'] = AttributesValueModel::selectAny($where);
        }
        if($attributesInfo)
        {
            return $attributesInfo;
        }
		return false;
    }
}