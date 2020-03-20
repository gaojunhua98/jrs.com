<?php

namespace app\model;

use app\model\ModelModel;
use think\facade\Db;

/**
 * @name 用户登陆表
 */
class UserModel extends ModelModel
{
    protected $connection = 'mysql';
    protected $name = 'user';
    protected $pk = 'uid';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }

}