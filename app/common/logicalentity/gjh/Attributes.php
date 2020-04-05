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

    /**
     * 修改属性信息
     */
    public function doUpdateAttributes($attributesId, $saveDate)
    {
        $where = [
            ['attributes_id', '=', $attributesId]
        ];
        $attributesInfo = AttributesModel::findOne($where);
        if(empty($attributesInfo))
        {
            return false;
        }
        $attributesData = [
            'attributes_name' => $saveDate['attributes_name'],
            'is_del' => $saveDate['is_del'],
        ];
        $res = AttributesModel::updateOne($where, $attributesData);
        //删除属性值
        $delData = [
            'is_del' => 1,
        ];
        AttributesValueModel::updateOne($where, $delData);
        if(!$saveDate['is_del'] == 1)
        {
            //添加属性值
            $res = $this->doCreateAttributesValue($saveDate);
        }
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加属性
     */
    public function doCreateAttributes($addInfo)
    {
        $attributesData = [
            'attributes_name' => $addInfo['attributes_name'],
            'is_del' => $addInfo['is_del'],
        ];
        if($attributesId = AttributesModel::addOne($attributesData))
        {
            $addInfo['attributes_id'] = $attributesId;
            $this->doCreateAttributesValue($addInfo);
            return true;
        }
		return false;
    }

    /**
     * 添加属性值
     */
    public function doCreateAttributesValue($addInfo)
    {
        $res = false;
        foreach($addInfo['newValue'] as $one)
        {
            $valueData = [];
            $valueData['attributes_id'] = $addInfo['attributes_id'];
            $valueData['attributes_value'] = $one;
            $valueData['is_del'] = 0;
            $res = AttributesValueModel::addOne($valueData);
        }
        if($res)
        {
            return true;
        }
		return false;
    }
}