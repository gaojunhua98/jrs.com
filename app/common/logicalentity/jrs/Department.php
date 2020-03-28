<?php

namespace app\common\logicalentity\jrs;

use app\model\jrs\DepartmentModel;

/**
 * @name 部门相关逻辑层
 */
class Department
{
    /**
     * 获取全部部门信息
     */
    public function doGetDepartmentList($where, $pageData)
    {
        $departmentInfo = DepartmentModel::getList($where, $pageData);
        if($departmentInfo)
        {
            return $departmentInfo;
        }
		return false;
    }

    /**
     * 修改部门信息
     */
    public function doUpdateDepartment($departmentId, $saveDate)
    {
        $where = [
            ['department_id', '=', $departmentId]
        ];
        $departmentInfo = DepartmentModel::findOne($where);
        if(empty($departmentInfo))
        {
            return false;
        }
        $res = DepartmentModel::updateOne($where, $saveDate);
        if($res != false)
        {
            return true;
        }
		return false;
    }

    /**
     * 添加部门
     */
    public function doCreateDepartment($addInfo)
    {
        if(DepartmentModel::addOne($addInfo))
        {
            return true;
        }
		return false;
    }
}