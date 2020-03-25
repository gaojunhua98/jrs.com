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
    
    public function addOneIgnore($data)
    {
    	return Db::name('user_info')->strick(false)->insert($data);
    }

    //列表页方法
    public function getUserInfoList($where, $pageData)
    {
        $list = Db::name('user_info userInfo')
                    ->field('user.user_email,user.user_phone,userInfo.user_nickname,userInfo.user_sex,userInfo.user_birth,userInfo.user_education,userInfo.user_address,userInfo.department_id,userInfo.department_name,userInfo.user_position')
                    ->where($where)
                    ->join('jrs_user user ON user.user_id = userInfo.user_id')
                    ->paginate($pageData['pageNum'], false, [
                        'type'     => 'Bootstrap',
                        'var_page' => 'page',
                        'page' => $pageData['page'],
            
                     ]);
        return $list;
    }
}