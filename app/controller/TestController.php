<?php

namespace app\controller;

use app\BaseController;
use think\facade\Db;

class TestController extends BaseController
{
    public function index()
    {
        $user = Db::name('users')->select();
        $user = Db::connect('mysql')->name('users')->select();
        $user = Db::name('users')->where('id', 1)->selectOrFail();
        $user = Db::name('users')->where('id', 1)->select()->toArray();    //返回数组

        $user = Db::name('users')->where('id', 1)->find();          
        $user = Db::name('users')->where('id', 1)->findOrFail();    //失败返回异常
        $user = Db::name('users')->where('id', 1)->findOrEmpty();   //失败返回空数组

        $user = Db::name('users')->where('id', 1)->value('name');
        $user = Db::name('users')->column('name', 'id');
        $user = Db::name('users')->chunk(100, function($users) {    //批量处理
            //...do something
        });

        $data = Db::name('users')->cursor();    //每次只读一行
        foreach($data as $value) {
            dump($value);
        }

        $usersQuery = Db::name('users');
        $user = $usersQuery->order('id', 'desc')->select();
        $user = $usersQuery->removeOption('where')->select(); //清除指定的链式信息,不清除则会保留

        $user = Db::name('users')->insert($data);
        $user = Db::name('users')->insertGetId($data);              //添加成功返回ID
        $user = Db::name('users')->strick(false)->insert($data);    //忽略多余的数据，进行插入
        $user = Db::name('users')->replace()->insert($data);        //符合的主键会updata操作

        $user = Db::name('users')->insertAll($data);       //返回影响行数

        $user = Db::name('users')->save($data);       //自动判断，存在主键为修改，不存在主键，为新增

        Db::getLastSql();  // 获取最后一条sql语句
        dump();       //调试错误，输出变量
        return json([
            'code' => 1,
            'msg' => '获取成功',
            'data' => $data
        ]);
    }

    public function hello()
    {
        return 111;
    }
}