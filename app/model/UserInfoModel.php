<?php

namespace app\model;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 用户信息表
 */
class UserInfoModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'user_info';
    protected $pk = 'user_info_id';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    
}