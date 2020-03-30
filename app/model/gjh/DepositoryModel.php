<?php

namespace app\model\gjh;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 用户登陆表
 */
class DepositoryModel extends ModelModel
{
    protected $connection = 'gjh';
    protected $name = 'depository';
    protected $pk = 'depository_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }

    public function addOneIgnore($data)
    {
    	return Db::name('depository')->strick(false)->insert($data);
    }

}