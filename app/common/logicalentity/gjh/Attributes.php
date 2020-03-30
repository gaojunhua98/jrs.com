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
        if($attributesInfo)
        {
            return $attributesInfo;
        }
		return false;
    }
}