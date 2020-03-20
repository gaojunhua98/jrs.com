<?php

namespace app\controller;

use app\controller\ControllerController;
use app\model\UsersModel as User;

class JurisdictionController extends ControllerController
{
    public function login()
    {
        $data['user_name'] = input('post.user_name');
        $data['user_password'] = input('post.user_password');

        // $user = 

        return  json([
            'code' => 1,
            'msg' => '获取成功',
            'data' => ''
        ]);
    }
}