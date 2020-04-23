<?php

namespace app\controller;

use app\BaseController;
use app\model\UsersModel as User;

class ControllerController extends BaseController
{
    public function getWhere($query)
    {
		$where = [];
		if(!empty($query)) {
			if(is_object($query)) {
				$query = (array)$query;
			}
			foreach($query as $key => $value)
			{
				if(!empty($value))
				{
					$where[] = [$key, 'LIKE', '%' . $value . '%'];
				}
			}
        }
        return $where;
    }
}