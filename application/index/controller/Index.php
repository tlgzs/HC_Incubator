<?php

namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Db;

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{

    /**
     * @return mixed
     * 登录页面
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 执行登陆
     */
    public function dologin()
    {
        //这里是管理员组,新增一个需要手动写进来,简单后台没搞权限分组啥的
        $admin_names = [
            'admin',
        ];
        $res = User::where('username', \input('username'))
            ->where('password', \input('password'))
            ->find();
        if ($res && \in_array(\input('username'), $admin_names)) {
            //如果是管理员就进入管理后台
            \session('admin_id', $res['id']);
            $this->redirect('admin/Index/index');
        } elseif ($res) {
            //如果是企业就进入企业后台
            \session('enterprise_id', $res['id']);
            $this->redirect('admin/Enterprise/index');
        } else {
            $this->error('登录失败,请联系管理员');
        }
    }

    /**
     *退出登录
     */
    public function logout(){
        \session(null);
        $this->redirect('/');
    }

    /**
     *修改密码
     */
    public function changePwd(){
        $admin_id = \session('admin_id');
        $enterprise_id = \session('enterprise_id');
        $pwd1 = \input('password1');
        $pwd2 = \input('password2');
        if ($pwd1 !=$pwd2){
            $this->error('两次密码不一致');
        }else{
            $res = Db::name('User')
                ->where('id', 'eq', $admin_id)
                ->whereOr('id', 'eq', $enterprise_id)
                ->setField('password', $pwd2);
            if ($res){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
    }
}
