<?php

namespace app\model\gjh;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 用户登陆表
 */
class AttributesModel extends ModelModel
{
    protected $connection = 'gjh';
    protected $name = 'attributes';
    protected $pk = 'attributes_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }

    public function addOneIgnore($data)
    {
    	return Db::name('attributes')->strick(false)->insert($data);
    }

}